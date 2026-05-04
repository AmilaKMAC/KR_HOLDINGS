<?php

namespace App\Http\Controllers\PaymentAndSalary;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentAndSalaryController extends Controller
{
    // =========================================================================
    // INDEX — current month, all technicians
    // =========================================================================
    public function index()
    {
        $now         = Carbon::now();
        $month       = (int) $now->month;
        $year        = (int) $now->year;
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

        $selectedTechnician = DB::table('user')
            ->where('iduser', $userId)
            ->select('iduser',
                DB::raw("CONCAT(first_name, ' ', COALESCE(last_name, '')) as name"))
            ->first();

        $currentPayment = $this->paymentDetailQuery()
            ->where('p.user_iduser', $userId)
            ->where('p.month', $month)
            ->where('p.year', $year)
            ->first();

        $previousPayments = $this->paymentDetailQuery()
            ->where('p.user_iduser', $userId)
            ->where(function ($q) use ($month, $year) {
                $q->where('p.year', '<', $year)
                  ->orWhere(function ($q2) use ($month, $year) {
                      $q2->where('p.year', $year)
                         ->where('p.month', '<', $month);
                  });
            })
            ->orderByDesc('p.year')
            ->orderByDesc('p.month')
            ->get();

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

        DB::table('payment')
            ->where('idpayment', $idpayment)
            ->update(['payment_status' => (int) $request->payment_status]);

        return redirect()->back()->with('success', 'Payment status updated.');
    }

    // =========================================================================
    // UPDATE OTHER PAYMENT
    // grand_total = basic_salary + process_total + other_payment
    // =========================================================================
    public function updateOtherPayment(Request $request, int $idpayment)
    {
        $request->validate(['other_payment' => 'required|numeric|min:0']);

        $payment = DB::table('payment')->where('idpayment', $idpayment)->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment record not found.');
        }

        $processTotal = (float) (DB::table('payment_process')
            ->where('idpayment', $idpayment)
            ->value('total') ?? 0);

        $grandTotal = round(
            (float) $payment->basic_salary + $processTotal + (float) $request->other_payment,
            2
        );

        DB::table('payment')
            ->where('idpayment', $idpayment)
            ->update([
                'other_payment' => $request->other_payment,
                'total'         => $grandTotal,
            ]);

        return redirect()->back()->with('success', 'Other payment updated.');
    }

    // =========================================================================
    // PRIVATE — main table: all technicians LEFT JOIN current month payment
    // attendance = 1 means present, approval = 1 means coordinator approved
    // =========================================================================
    private function getTechnicianList(int $month, int $year)
    {
        return DB::table('user as u')
            ->join('technician_registration as tr',
                'u.technician_registration_idtechnician_registration', '=',
                'tr.idtechnician_registration')
            ->join('technician_level as tl',
                'tr.technician_level_idtechnician_level', '=',
                'tl.idtechnician_level')
            ->leftJoin('payment as p', function ($join) use ($month, $year) {
                $join->on('p.user_iduser', '=', 'u.iduser')
                     ->where('p.month', '=', $month)
                     ->where('p.year', '=', $year);
            })
            ->leftJoin('payment_process as pp', 'pp.idpayment', '=', 'p.idpayment')
            ->leftJoin('solar as s', 'pp.solar_idsolar', '=', 's.idsolar')
            ->leftJoin('additional_work as aw',
                'pp.additional_work_idadditional_work', '=', 'aw.idadditional_work')
            ->where('u.user_role_iduser_role', 4)
            ->where('u.status', 1)
            ->select(
                'u.iduser',
                DB::raw("CONCAT(u.first_name, ' ', COALESCE(u.last_name, '')) as name"),
                'tl.basic_salary as level_basic_salary',
                'p.idpayment',
                'p.month',
                'p.year',
                'p.basic_salary',
                'p.other_payment',
                'p.payment_status',
                'p.total',
                'pp.idpayment_process',
                'pp.total as process_total',
                'aw.rate as additional_work_rate',
                's.rate as solar_rate',

                // Days this technician was present (attendance=1) AND approved (approval=1)
                DB::raw("(
                    SELECT COUNT(DISTINCT a.date)
                    FROM attendance a
                    WHERE a.user_iduser  = u.iduser
                      AND a.attendance   = 1
                      AND a.approval     = 1
                      AND MONTH(a.date)  = {$month}
                      AND YEAR(a.date)   = {$year}
                ) as days_attended"),

                // Total working days = distinct dates any technician was present & approved
                DB::raw("(
                    SELECT COUNT(DISTINCT a.date)
                    FROM attendance a
                    WHERE a.attendance  = 1
                      AND a.approval    = 1
                      AND MONTH(a.date) = {$month}
                      AND YEAR(a.date)  = {$year}
                ) as total_working_days")
            )
            ->get();
    }

    // =========================================================================
    // PRIVATE — detail query for modal (only technicians with payment records)
    // =========================================================================
    private function paymentDetailQuery()
    {
        return DB::table('payment as p')
            ->join('payment_process as pp', 'p.idpayment', '=', 'pp.idpayment')
            ->join('user as u', 'p.user_iduser', '=', 'u.iduser')
            ->join('technician_level as tl',
                'pp.technician_level_idtechnician_level', '=', 'tl.idtechnician_level')
            ->join('solar as s', 'pp.solar_idsolar', '=', 's.idsolar')
            ->join('additional_work as aw',
                'pp.additional_work_idadditional_work', '=', 'aw.idadditional_work')
            ->select(
                'u.iduser',
                DB::raw("CONCAT(u.first_name, ' ', COALESCE(u.last_name, '')) as name"),
                'p.idpayment',
                'p.month',
                'p.year',
                'p.payment_status',
                'p.basic_salary',
                'p.other_payment',
                'p.total',
                'pp.idpayment_process',
                'pp.total as process_total',
                'tl.basic_salary as level_basic_salary',
                'aw.rate as additional_work_rate',
                's.rate as solar_rate',

                // Days present & approved for the payment's specific month/year
                DB::raw('(
                    SELECT COUNT(DISTINCT a.date)
                    FROM attendance a
                    WHERE a.user_iduser  = p.user_iduser
                      AND a.attendance   = 1
                      AND a.approval     = 1
                      AND MONTH(a.date)  = p.month
                      AND YEAR(a.date)   = p.year
                ) as days_attended'),

                // Total working days for the payment's specific month/year
                DB::raw('(
                    SELECT COUNT(DISTINCT a.date)
                    FROM attendance a
                    WHERE a.attendance  = 1
                      AND a.approval    = 1
                      AND MONTH(a.date) = p.month
                      AND YEAR(a.date)  = p.year
                ) as total_working_days')
            );
    }
}