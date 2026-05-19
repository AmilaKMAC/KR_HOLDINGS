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

    // ── 1. Technician level & basic salary ───────────────────────────────
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

    // ── 2. Total approved working days this month (all technicians) ──────
    $totalWorkingDays = DB::table('attendance')
        ->whereBetween('date', [$monthStart, $monthEnd])
        ->where('attendance', 1)
        ->where('approval', 1)
        ->distinct()
        ->count('date');

    if ($totalWorkingDays === 0) $totalWorkingDays = 1;

    // ── 3. Days this technician attended & was approved ──────────────────
    $daysAttended = DB::table('attendance')
        ->where('user_iduser', $userId)
        ->whereBetween('date', [$monthStart, $monthEnd])
        ->where('attendance', 1)
        ->where('approval', 1)
        ->distinct()
        ->count('date');

    // ── 4. Pro-rated basic salary ─────────────────────────────────────────
    $basicSalaryEarned = round(
        ($techReg->level_basic_salary / $totalWorkingDays) * $daysAttended,
        2
    );

    // ── 5. All approved projects this technician completed this month ─────
    $completedProjects = DB::table('work_completion_technician as wct')
        ->join('work_completion as wc',
            'wct.work_completion_idwork_completion', '=', 'wc.idwork_completion')
        ->join('project as pr', 'wc.Project_idProject', '=', 'pr.idProject')
        ->join('solar as s', 'pr.solar_idsolar', '=', 's.idsolar')
        ->where('wct.user_iduser', $userId)
        ->whereBetween('wc.completion_date', [$monthStart, $monthEnd])
        ->select('pr.idProject', 's.rate as solar_rate')
        ->get()
        ->unique('idProject');

    // ── 6. Build per-project totals ───────────────────────────────────────
    $projectBreakdowns = $completedProjects->map(function ($proj) {
        $additionalWorks = DB::table('proof_additional_work as paw')
            ->join('additional_work as aw',
                'paw.idadditional_work', '=', 'aw.idadditional_work')
            ->where('paw.Project_idProject', $proj->idProject)
            ->select('aw.idadditional_work', 'aw.rate')
            ->get();

        return [
            'idProject'       => $proj->idProject,
            'solar_rate'      => (float) $proj->solar_rate,
            'additionalWorks' => $additionalWorks,  // collection of {idadditional_work, rate}
            'project_total'   => round((float) $proj->solar_rate + $additionalWorks->sum('rate'), 2),
        ];
    });

    // ── 7. Process total (sum of all project totals) ──────────────────────
    $processTotal = round($projectBreakdowns->sum('project_total'), 2);

    // ── 8. Upsert payment row ─────────────────────────────────────────────
    $existingPayment = DB::table('payment')
        ->where('user_iduser', $userId)
        ->where('month', $month)
        ->where('year', $year)
        ->first();

    DB::transaction(function () use (
        $userId, $month, $year, $now,
        $techReg, $projectBreakdowns,
        $basicSalaryEarned, $processTotal,
        $existingPayment
    ) {
        if ($existingPayment) {
            $otherPayment = (float) ($existingPayment->other_payment ?? 0);
            $grandTotal   = round($basicSalaryEarned + $processTotal + $otherPayment, 2);

            DB::table('payment')
                ->where('idpayment', $existingPayment->idpayment)
                ->update([
                    'basic_salary'  => $basicSalaryEarned,
                    'process_total' => $processTotal,
                    'total'         => $grandTotal,
                    'date'          => $now->toDateTimeString(),
                ]);

            $idpayment = $existingPayment->idpayment;

        } else {
            $grandTotal = round($basicSalaryEarned + $processTotal, 2);

            $idpayment = DB::table('payment')->insertGetId([
                'user_iduser'    => $userId,
                'month'          => $month,
                'year'           => $year,
                'basic_salary'   => $basicSalaryEarned,
                'other_payment'  => 0.00,
                'process_total'  => $processTotal,
                'total'          => $grandTotal,
                'date'           => $now->toDateTimeString(),
                'payment_status' => 0,
            ]);
        }

        // ── 9. Rebuild payment_process rows cleanly ───────────────────────
        // Delete old additional works first, then old process rows
        $oldProcessIds = DB::table('payment_process')
            ->where('idpayment', $idpayment)
            ->pluck('idpayment_process');

        if ($oldProcessIds->isNotEmpty()) {
            DB::table('payment_process_additional_work')
                ->whereIn('payment_process_idpayment_process', $oldProcessIds)
                ->delete();

            DB::table('payment_process')
                ->whereIn('idpayment_process', $oldProcessIds)
                ->delete();
        }

        // Insert one payment_process row per project, with its additional works
        foreach ($projectBreakdowns as $breakdown) {
            $processId = DB::table('payment_process')->insertGetId([
                'user_iduser'                         => $userId,
                'project_idProject'                   => $breakdown['idProject'],
                'idpayment'                           => $idpayment,
                'technician_level_idtechnician_level' => $techReg->technician_level_idtechnician_level,
                'total'                               => $breakdown['project_total'],
            ]);

            foreach ($breakdown['additionalWorks'] as $aw) {
                DB::table('payment_process_additional_work')->insert([
                    'payment_process_idpayment_process' => $processId,
                    'additional_work_idadditional_work' => $aw->idadditional_work,
                ]);
            }
        }
    });
}
}