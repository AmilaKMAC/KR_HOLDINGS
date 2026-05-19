<?php

namespace App\Http\Controllers\PaymentAndSalary;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\PaymentAndSalary\Payment;
use App\Models\UserManagement\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SystemSettings\AttendanceRate;

class PaymentAndSalaryController extends Controller
{
    // =========================================================================
    // PRIVATE — fetch attendance rate from DB
    // =========================================================================
    private function getAttendanceRate(): float
    {
        return (float) (AttendanceRate::value('rate') ?? 0);
    }

    // =========================================================================
    // INDEX — current month, all technicians
    // =========================================================================
    public function index()
    {
        $now   = Carbon::now();
        $month = (int) $now->month;
        $year  = (int) $now->year;

        $user = auth()->user();

        if ($user->user_role_iduser_role == 4) {
            $previousPayments = $this->paymentDetailQuery()
                ->where('user_iduser', $user->iduser)
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->get()
                ->map(fn($p) => $this->appendAttendance($p));

            return view('users.components.payment_and_salary', [
                'title'            => 'Payment and Salary',
                'previousPayments' => $previousPayments,
                'currentMonth'     => $now->format('F Y'),
            ]);
        }

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

        $selectedTechnician = User::select('iduser')
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

        $attendanceRate = $this->getAttendanceRate();

        $payment = Payment::with([
            'paymentProcesses.technicianLevel',
            'paymentProcesses.solar',
            'paymentProcesses.additionalWork',
        ])->findOrFail($idpayment);

        $processTotal    = (float) $payment->paymentProcesses->sum('total');
        $daysAttended    = $this->getDaysAttended($payment->user_iduser, $payment->month, $payment->year);
        $attendanceBonus = $daysAttended * $attendanceRate;

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
        $attendanceRate   = $this->getAttendanceRate();

        $technicians = User::with([
                'TechnicianRegistration.technicianLevel',
                'payments' => function ($q) use ($month, $year) {
                    $q->with([
                        'paymentProcesses.project.solar',
                        'paymentProcesses.additionalWorks.additionalWork',
                        'paymentProcesses.technicianLevel',
                    ])
                    ->where('month', $month)
                    ->where('year', $year);
                },
            ])
            ->where('user_role_iduser_role', 4)
            ->where('status', 1)
            ->get();

        return $technicians->map(function ($user) use ($month, $year, $totalWorkingDays, $attendanceRate) {

            $daysAttended    = $this->getDaysAttended($user->iduser, $month, $year);
            $attendanceBonus = $daysAttended * $attendanceRate;

            $payment          = $user->payments->first();
            $paymentProcesses = $payment?->paymentProcesses ?? collect();
            $techLevel        = $user->TechnicianRegistration?->technicianLevel;

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
                'attendance_rate'    => $attendanceRate,
                'idpayment'          => $payment?->idpayment,
                'month'              => $payment?->month,
                'year'               => $payment?->year,
                'basic_salary'       => $payment?->basic_salary,
                'other_payment'      => $payment?->other_payment,
                'payment_status'     => $payment?->payment_status,
                'total'              => $grandTotal,
                'process_total'      => $processTotal ?: null,
                'payment_processes'  => $paymentProcesses,
                'days_attended'      => $daysAttended,
                'attendance_bonus'   => $attendanceBonus,
                'total_working_days' => $totalWorkingDays,
            ];
        });
    }

    // =========================================================================
    // PRIVATE — reusable payment query with eager loads
    // =========================================================================
    private function paymentDetailQuery()
    {
        return Payment::with([
            'paymentProcesses.project.solar',
            'paymentProcesses.additionalWorks.additionalWork',
            'paymentProcesses.technicianLevel',
            'user',
        ]);
    }

    // =========================================================================
    // PRIVATE — append attendance data to a Payment model
    // =========================================================================
    private function appendAttendance(Payment $payment): object
    {
        if (! $payment->relationLoaded('paymentProcesses')) {
            $payment->load([
                'paymentProcesses.project.solar',
                'paymentProcesses.additionalWorks.additionalWork',
                'paymentProcesses.technicianLevel',
            ]);
        }

        $attendanceRate   = $this->getAttendanceRate();
        $daysAttended     = $this->getDaysAttended($payment->user_iduser, $payment->month, $payment->year);
        $totalWorkingDays = $this->getTotalWorkingDays($payment->month, $payment->year);
        $attendanceBonus  = $daysAttended * $attendanceRate;

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
            'attendance_rate'    => $attendanceRate,
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
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->distinct('date')
            ->count('date');
    }
}