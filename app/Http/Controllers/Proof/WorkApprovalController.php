<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\Proof\ProofOfWork;
use App\Models\Proof\WorkCompletion;
use App\Models\Proof\WorkCompletionTechnician;
use App\Models\SystemSettings\AdditionalWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkApprovalController extends Controller
{
    // =========================================================================
    // INDEX
    // =========================================================================
    public function index()
    {
        $pendingProofs = ProofOfWork::with([
            'project.Solar',
            'project.Partner',
            'project.assignedTechnicians.technician',
            'images',
            'additionalWorks',
        ])->where('approval', 0)->get();

        $approvedProofs = ProofOfWork::with([
            'project.Solar',
            'project.Partner',
            'project.assignedTechnicians.technician',
            'images',
            'additionalWorks',
        ])->where('approval', 1)->get();

        $additionalWorkOptions = AdditionalWork::all();

        return view('users.components.proof_of_work_approval', [
            'pending'               => $pendingProofs,
            'approved'              => $approvedProofs,
            'additionalWorkOptions' => $additionalWorkOptions,
            'title'                 => 'Proof of Work Approval',
        ]);
    }

    // =========================================================================
    // APPROVE
    // =========================================================================
    public function approve(Request $request)
    {
        $request->validate([
            'idproof_of_work'                     => 'required|integer',
            'additional_work_idadditional_work'   => 'nullable|array',
            'additional_work_idadditional_work.*' => 'integer',
        ]);

        $proofOfWork = ProofOfWork::findOrFail($request->idproof_of_work);

        // Sync additional works via pivot
        $proofOfWork->additionalWorks()->sync(
            $request->input('additional_work_idadditional_work', [])
        );

        $proofOfWork->update(['approval' => 1]);
        $proofOfWork->project->update(['status' => 1]);

        $workCompletion = WorkCompletion::firstOrCreate(
            ['Project_idProject' => $proofOfWork->Project_idProject],
            ['completion_date'   => now()]
        );

        $assignedTechnicians = AssignTechnician::query()
            ->where('Project_idProject', $proofOfWork->Project_idProject)
            ->get();

        foreach ($assignedTechnicians as $assigned) {
            WorkCompletionTechnician::firstOrCreate([
                'work_completion_idwork_completion' => $workCompletion->idwork_completion,
                'user_iduser'                       => $assigned->user_iduser,
            ]);

            $this->recalculateMonthlyPayment($assigned->user_iduser);
        }

        return redirect()->route('proof_of_work_approval.index')
            ->with('success', 'Project approved and payments updated!');
    }

    // =========================================================================
    // UNAPPROVE
    // =========================================================================
public function unapprove(Request $request)
{
    $request->validate([
        'idproof_of_work'  => 'required|integer',
        'unapprove_reason' => 'required|string|max:500',
    ]);

    $proofOfWork = ProofOfWork::findOrFail($request->idproof_of_work);

    $proofOfWork->update([
        'approval'         => 0,
        'unapprove_reason' => $request->unapprove_reason,
    ]);

    $proofOfWork->project->update(['status' => 0]);
    $proofOfWork->additionalWorks()->detach();

    WorkCompletion::query()
        ->where('Project_idProject', $proofOfWork->Project_idProject)
        ->delete();

    $assignedTechnicians = AssignTechnician::query()
        ->where('Project_idProject', $proofOfWork->Project_idProject)
        ->get();

    foreach ($assignedTechnicians as $assigned) {
        $this->recalculateMonthlyPayment($assigned->user_iduser);
    }

    return redirect()->route('proof_of_work_approval.index')
        ->with('success', 'Approval revoked. Technician notified to re-upload.');
}
    // =========================================================================
    // SAVE ADDITIONAL WORK
    // =========================================================================
    public function saveAdditionalWork(Request $request)
    {
        $request->validate([
            'idproof_of_work'                     => 'required|integer',
            'additional_work_idadditional_work'   => 'nullable|array',
            'additional_work_idadditional_work.*' => 'integer',
        ]);

        $proofOfWork = ProofOfWork::findOrFail($request->idproof_of_work);

        $proofOfWork->additionalWorks()->sync(
            $request->input('additional_work_idadditional_work', [])
        );

        return redirect()->route('proof_of_work_approval.index')
            ->with('success', 'Additional work saved successfully!');
    }

    

    // =========================================================================
    // RECALCULATE MONTHLY PAYMENT
    // Called on every approve / unapprove for each assigned technician.
    //
    // Grand Total = basic_salary_earned + solar_total + additional_work_total + other_payment
    // basic_salary_earned = level_basic_salary × (days_attended / total_working_days)
    // =========================================================================
    private function recalculateMonthlyPayment(int $userId): void
    {
        $now        = Carbon::now();
        $month      = (int) $now->month;
        $year       = (int) $now->year;
        $monthStart = $now->copy()->startOfMonth()->toDateString();
        $monthEnd   = $now->copy()->endOfMonth()->toDateString();

        // ── 1. Get technician level & full basic salary ───────────────────────
        $techReg = DB::table('user as u')
            ->join('technician_registration as tr',
                'u.technician_registration_idtechnician_registration', '=',
                'tr.idtechnician_registration')
            ->join('technician_level as tl',
                'tr.technician_level_idtechnician_level', '=',
                'tl.idtechnician_level')
            ->where('u.iduser', $userId)
            ->select(
                'tr.technician_level_idtechnician_level',
                'tl.basic_salary as level_basic_salary'
            )
            ->first();

        if (!$techReg) return;

        // ── 2. Total working days this month (present=1 AND approved=1) ──────
        $totalWorkingDays = DB::table('attendance')
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->where('attendance', 1)
            ->where('approval', 1)
            ->distinct()
            ->count('date');

        // Prevent division by zero
        if ($totalWorkingDays === 0) $totalWorkingDays = 1;

        // ── 3. Days THIS technician was present AND approved this month ────────
        $daysAttended = DB::table('attendance')
            ->where('user_iduser', $userId)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->where('attendance', 1)
            ->where('approval', 1)
            ->distinct()
            ->count('date');

        // ── 4. Pro-rated basic salary ─────────────────────────────────────────
        // basic_salary_earned = level_basic_salary × (days_attended / total_working_days)
        $basicSalaryEarned = round(
            ($techReg->level_basic_salary / $totalWorkingDays) * $daysAttended,
            2
        );

        // ── 5. All approved projects this technician completed this month ──────
        $completedProjects = DB::table('work_completion_technician as wct')
            ->join('work_completion as wc',
                'wct.work_completion_idwork_completion', '=', 'wc.idwork_completion')
            ->join('project as pr', 'wc.Project_idProject', '=', 'pr.idProject')
            ->join('solar as s', 'pr.solar_idsolar', '=', 's.idsolar')
            ->where('wct.user_iduser', $userId)
            ->whereBetween('wc.completion_date', [$monthStart, $monthEnd])
            ->select(
                'pr.idProject',
                'pr.solar_idsolar',
                's.rate as solar_rate'
            )
            ->get();

        // ── 6. Solar total: one rate per unique project ───────────────────────
        $totalSolarRate = $completedProjects->unique('idProject')->sum('solar_rate');

        // ── 7. Additional work total: SUM all rates from pivot for these projects ──
        $projectIds = $completedProjects->pluck('idProject')->unique()->values();

        $totalAdditionalWork = $projectIds->isNotEmpty()
            ? DB::table('proof_additional_work as paw')
                ->join('additional_work as aw',
                    'paw.idadditional_work', '=', 'aw.idadditional_work')
                ->whereIn('paw.Project_idProject', $projectIds)
                ->sum('aw.rate')
            : 0;

        $processTotal = round((float)$totalSolarRate + (float)$totalAdditionalWork, 2);

        // ── 8. FK references for payment_process ─────────────────────────────
        $refSolarId = $completedProjects->isNotEmpty()
            ? $completedProjects->first()->solar_idsolar
            : DB::table('solar')->value('idsolar');

        $refAdditionalId = $projectIds->isNotEmpty()
            ? DB::table('proof_additional_work')
                ->whereIn('Project_idProject', $projectIds)
                ->value('idadditional_work')
            : null;

        $refAdditionalId = $refAdditionalId
            ?? DB::table('additional_work')->value('idadditional_work');

        // ── 9. Upsert payment + payment_process ──────────────────────────────
        $existingPayment = DB::table('payment')
            ->where('user_iduser', $userId)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($existingPayment) {
            // Preserve other_payment already set by executive
            $otherPayment = (float) ($existingPayment->other_payment ?? 0);
            $grandTotal   = round($basicSalaryEarned + $processTotal + $otherPayment, 2);

            DB::table('payment')
                ->where('idpayment', $existingPayment->idpayment)
                ->update([
                    'basic_salary' => $basicSalaryEarned,
                    'total'        => $grandTotal,
                    'date'         => $now->toDateTimeString(),
                ]);

            DB::table('payment_process')
                ->where('idpayment', $existingPayment->idpayment)
                ->update([
                    'technician_level_idtechnician_level' => $techReg->technician_level_idtechnician_level,
                    'solar_idsolar'                       => $refSolarId,
                    'additional_work_idadditional_work'   => $refAdditionalId,
                    'total'                               => $processTotal,
                ]);

        } else {
            $otherPayment = 0.00;
            $grandTotal   = round($basicSalaryEarned + $processTotal, 2);

            DB::transaction(function () use (
                $userId, $month, $year, $now,
                $techReg, $refSolarId, $refAdditionalId,
                $basicSalaryEarned, $processTotal, $otherPayment, $grandTotal
            ) {
                $idpayment = DB::table('payment')->insertGetId([
                    'user_iduser'    => $userId,
                    'month'          => $month,
                    'year'           => $year,
                    'basic_salary'   => $basicSalaryEarned,
                    'other_payment'  => $otherPayment,
                    'total'          => $grandTotal,
                    'date'           => $now->toDateTimeString(),
                    'payment_status' => 0,
                ]);

                DB::table('payment_process')->insert([
                    'user_iduser'                         => $userId,
                    'idpayment'                           => $idpayment,
                    'technician_level_idtechnician_level' => $techReg->technician_level_idtechnician_level,
                    'solar_idsolar'                       => $refSolarId,
                    'additional_work_idadditional_work'   => $refAdditionalId,
                    'others'                              => 0,
                    'total'                               => $processTotal,
                ]);
            });
        }
    }
}