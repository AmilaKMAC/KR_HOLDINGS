<?php

namespace App\Http\Controllers\PaymentAndSalary;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\PaymentAndSalary\Payment;
use App\Models\UserManagement\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentAndSalaryController extends Controller
{
    // Flat attendance rate per day (replace with per-technician DB lookup later)
    const ATTENDANCE_RATE = 1000;

    // =========================================================================
    // INDEX — current month, all technicians
    // =========================================================================
    public function index()
    {
        $now   = Carbon::now();
        $month = (int) $now->month;
        $year  = (int) $now->year;

        $technicians = $this->getTechnicianList($month, $year);

        return view('users.components.payment_and_salary', [
            'title'        => 'Payment and Salary',
            'technicians'  => $technicians,
            'currentMonth' => $now->format('F Y'),
        ]);
    }

    // =========================================================================
    // HISTORY — same blade, opens modal for one technician
    // =========================================================================
    public function history(int $userId)
    {
        $now   = Carbon::now();
        $month = (int) $now->month;
        $year  = (int) $now->year;

        $technicians = $this->getTechnicianList($month, $year);

        $selectedTechnician = User::select('iduser', 'first_name', 'last_name')
            ->selectRaw("CONCAT(first_name, ' ', COALESCE(last_name, '')) as name")
            ->findOrFail($userId);

        $currentPayment = $this->paymentDetailQuery()
            ->where('user_iduser', $userId)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($currentPayment) {
            $currentPayment = $this->appendAttendance($currentPayment);
        }

        $previousPayments = $this->paymentDetailQuery()
            ->where('user_iduser', $userId)
            ->where(function ($q) use ($month, $year) {
                $q->where('year', '<', $year)
                  ->orWhere(function ($q2) use ($month, $year) {
                      $q2->where('year', $year)
                         ->where('month', '<', $month);
                  });
            })
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get()
            ->map(fn($p) => $this->appendAttendance($p));

        return view('users.components.payment_and_salary', [
            'title'              => 'Payment and Salary',
            'technicians'        => $technicians,
            'currentMonth'       => $now->format('F Y'),
            'selectedTechnician' => $selectedTechnician,
            'currentPayment'     => $currentPayment,
            'previousPayments'   => $previousPayments,
            'openModal'          => true,
        ]);
    }

    // =========================================================================
    // UPDATE STATUS
    // =========================================================================
    public function updateStatus(Request $request, int $idpayment)
    {
        $request->validate(['payment_status' => 'required|in:0,1']);

        Payment::findOrFail($idpayment)
            ->update(['payment_status' => (int) $request->payment_status]);

        return redirect()->back()->with('success', 'Payment status updated.');
    }

    // =========================================================================
    // UPDATE OTHER PAYMENT
    // grand_total = basic_salary + (days_attended × attendance_rate)
    //             + sum(all process totals) + other_payment
    // =========================================================================
    public function updateOtherPayment(Request $request, int $idpayment)
    {
        $request->validate(['other_payment' => 'required|numeric|min:0']);

        $payment = Payment::with([
            'paymentProcesses.technicianLevel',
            'paymentProcesses.solar',
            'paymentProcesses.additionalWork',
        ])->findOrFail($idpayment);

        $processTotal    = (float) $payment->paymentProcesses->sum('total');
        $daysAttended    = $this->getDaysAttended($payment->user_iduser, $payment->month, $payment->year);
        $attendanceBonus = $daysAttended * self::ATTENDANCE_RATE;

        $grandTotal = round(
            (float) $payment->basic_salary
            + $attendanceBonus
            + $processTotal
            + (float) $request->other_payment,
            2
        );

        $payment->update([
            'other_payment' => $request->other_payment,
            'total'         => $grandTotal,
        ]);

        return redirect()->back()->with('success', 'Other payment updated.');
    }

    // =========================================================================
    // PRIVATE — build technician list with current-month payment data
    // =========================================================================
    private function getTechnicianList(int $month, int $year)
    {
        $totalWorkingDays = $this->getTotalWorkingDays($month, $year);

        $technicians = User::with([
                'TechnicianRegistration.technicianLevel',
                'payments' => function ($q) use ($month, $year) {
                    $q->with([
                        'paymentProcesses.technicianLevel',
                        'paymentProcesses.solar',
                        'paymentProcesses.additionalWork',
                    ])
                    ->where('month', $month)
                    ->where('year', $year);
                },
            ])
            ->where('user_role_iduser_role', 4)
            ->where('status', 1)
            ->get();

        return $technicians->map(function ($user) use ($month, $year, $totalWorkingDays) {

            $daysAttended    = $this->getDaysAttended($user->iduser, $month, $year);
            $attendanceBonus = $daysAttended * self::ATTENDANCE_RATE;

            $payment          = $user->payments->first();
            $paymentProcesses = $payment?->paymentProcesses ?? collect();
            $techLevel        = $user->TechnicianRegistration?->technicianLevel;

            // Sum all project totals
            $processTotal = $paymentProcesses->sum('total');

            $grandTotal = $payment ? round(
                (float) $payment->basic_salary
                + $attendanceBonus
                + (float) $processTotal
                + (float) ($payment->other_payment ?? 0),
                2
            ) : null;

            return (object) [
                'iduser'             => $user->iduser,
                'name'               => trim($user->first_name . ' ' . $user->last_name),
                'level_basic_salary' => $techLevel?->basic_salary ?? 0,
                'attendance_rate'    => self::ATTENDANCE_RATE,

                // Payment fields
                'idpayment'          => $payment?->idpayment,
                'month'              => $payment?->month,
                'year'               => $payment?->year,
                'basic_salary'       => $payment?->basic_salary,
                'other_payment'      => $payment?->other_payment,
                'payment_status'     => $payment?->payment_status,
                'total'              => $grandTotal,

                // All project rows for this month
                'process_total'      => $processTotal ?: null,
                'payment_processes'  => $paymentProcesses,

                // Attendance
                'days_attended'      => $daysAttended,
                'attendance_bonus'   => $attendanceBonus,
                'total_working_days' => $totalWorkingDays,
            ];
        });
    }

    // =========================================================================
    // PRIVATE — base query for payment detail (modal use)
    // =========================================================================
    private function paymentDetailQuery()
    {
        return Payment::with([
            'paymentProcesses.technicianLevel',
            'paymentProcesses.solar',
            'paymentProcesses.additionalWork',
            'paymentProcesses.project',
            'user',
        ]);
    }

    // =========================================================================
    // PRIVATE — append attendance + bonus onto a Payment, return stdClass
    // FIX: ensure all sub-relations are loaded before accessing them
    // =========================================================================
    private function appendAttendance(Payment $payment): object
    {
        // Ensure sub-relations are loaded (guards against lazy-load missing nested relations)
        if (! $payment->relationLoaded('paymentProcesses')) {
            $payment->load([
                'paymentProcesses.technicianLevel',
                'paymentProcesses.solar',
                'paymentProcesses.additionalWork',
                'paymentProcesses.project',
            ]);
        } else {
            // Sub-relations may still be missing even if paymentProcesses is loaded
            $payment->paymentProcesses->each(function ($process) {
                if (! $process->relationLoaded('solar')) {
                    $process->load('solar');
                }
                if (! $process->relationLoaded('additionalWork')) {
                    $process->load('additionalWork');
                }
                if (! $process->relationLoaded('technicianLevel')) {
                    $process->load('technicianLevel');
                }
                if (! $process->relationLoaded('project')) {
                    $process->load('project');
                }
            });
        }

        $daysAttended     = $this->getDaysAttended($payment->user_iduser, $payment->month, $payment->year);
        $totalWorkingDays = $this->getTotalWorkingDays($payment->month, $payment->year);
        $attendanceBonus  = $daysAttended * self::ATTENDANCE_RATE;

        $processes    = $payment->paymentProcesses ?? collect();
        $processTotal = $processes->sum('total');

        $grandTotal = round(
            (float) $payment->basic_salary
            + $attendanceBonus
            + (float) $processTotal
            + (float) ($payment->other_payment ?? 0),
            2
        );

        return (object) [
            'iduser'             => $payment->user_iduser,
            'name'               => trim(($payment->user->first_name ?? '') . ' ' . ($payment->user->last_name ?? '')),
            'idpayment'          => $payment->idpayment,
            'month'              => $payment->month,
            'year'               => $payment->year,
            'payment_status'     => $payment->payment_status,
            'basic_salary'       => $payment->basic_salary,
            'other_payment'      => $payment->other_payment,
            'total'              => $grandTotal,
            'level_basic_salary' => $processes->first()?->technicianLevel?->basic_salary ?? 0,
            'attendance_rate'    => self::ATTENDANCE_RATE,
            'process_total'      => $processTotal ?: null,
            'payment_processes'  => $processes,
            'days_attended'      => $daysAttended,
            'attendance_bonus'   => $attendanceBonus,
            'total_working_days' => $totalWorkingDays,
        ];
    }

    // =========================================================================
    // PRIVATE — days a specific technician was present & approved
    // =========================================================================
    private function getDaysAttended(int $userId, int $month, int $year): int
    {
        return Attendance::presentAndApproved()
            ->where('user_iduser', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->distinct('date')
            ->count('date');
    }

    // =========================================================================
    // PRIVATE — total distinct working days for a month/year
    // =========================================================================
    private function getTotalWorkingDays(int $month, int $year): int
    {
        return Attendance::presentAndApproved()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->distinct('date')
            ->count('date');
    }
}