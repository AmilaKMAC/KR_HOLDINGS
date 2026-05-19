<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\PaymentAndSalary\Payment;
use App\Models\SystemSettings\AttendanceRate;
use Carbon\Carbon;

class ProfileController extends Controller
{
public function index()
{
    $now  = Carbon::now();
    $user = auth()->user()->load('TechnicianRegistration');

    $previousPayments = Payment::with([
        'paymentProcesses.technicianLevel',
        'paymentProcesses.project.solar',
        'paymentProcesses.additionalWorks.additionalWork',
        'user',
    ])
    ->where('user_iduser', $user->iduser)
    ->orderByDesc('year')
    ->orderByDesc('month')
    ->get()
    ->map(fn($p) => $this->appendAttendance($p));

    return view('users.components.profile', [
        'title'            => 'Profile',
        'user'             => $user,
        'previousPayments' => $previousPayments,
        'currentMonth'     => $now->format('F Y'),
    ]);
}

    private function appendAttendance(Payment $payment): object
    {
        $attendanceRate   = (float) (AttendanceRate::value('rate') ?? 0);
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
            'idpayment'          => $payment->idpayment,
            'month'              => $payment->month,
            'year'               => $payment->year,
            'payment_status'     => $payment->payment_status,
            'basic_salary'       => $payment->basic_salary,
            'other_payment'      => $payment->other_payment,
            'total'              => $grandTotal,
            'process_total'      => $processTotal ?: null,
            'payment_processes'  => $processes,
            'days_attended'      => $daysAttended,
            'attendance_bonus'   => $attendanceBonus,
            'total_working_days' => $totalWorkingDays,
        ];
    }

private function getDaysAttended(int $userId, int $month, int $year): int
{
    return Attendance::where('user_iduser', $userId)
        ->where('attendance', 1)
        ->where('approval', 1)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->distinct('date')
        ->count('date');
}

private function getTotalWorkingDays(int $month, int $year): int
{
    return Attendance::where('attendance', 1)
        ->where('approval', 1)
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->distinct('date')
        ->count('date');
}
}