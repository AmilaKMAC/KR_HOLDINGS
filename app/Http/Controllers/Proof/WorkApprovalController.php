<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\Proof\ProofOfWork;
use App\Models\Proof\WorkCompletion;
use App\Models\Proof\WorkCompletionTechnician;
use App\Models\SystemSettings\AdditionalWork;
use Illuminate\Http\Request;

class WorkApprovalController extends Controller
{
    public function index()
    {
        $pending = ProofOfWork::with([
            'project.Solar',
            'project.Partner',
            'project.assignedTechnicians.technician',
            'images',
            'additionalWorks',
        ])->where('approval', 0)->get();

        $approved = ProofOfWork::with([
            'project.Solar',
            'project.Partner',
            'project.assignedTechnicians.technician',
            'images',
            'additionalWorks',
        ])->where('approval', 1)->get();

        $additionalWorkOptions = AdditionalWork::all();

        return view('users.components.proof_of_work_approval', [
            'pending'               => $pending,
            'approved'              => $approved,
            'additionalWorkOptions' => $additionalWorkOptions,
            'title'                 => 'Proof of Work Approval',
        ]);
    }
public function approve(Request $request)
{
    $request->validate([
        'idproof_of_work'                     => 'required|integer',
        'additional_work_idadditional_work'   => 'nullable|array',
        'additional_work_idadditional_work.*' => 'integer',
    ]);

    $proof = ProofOfWork::findOrFail($request->idproof_of_work);

    // Sync additional works
    $proof->additionalWorks()->sync(
        $request->input('additional_work_idadditional_work', [])
    );

    // Mark proof as approved
    $proof->update(['approval' => 1]);

    // Mark project as completed
    $proof->project->update(['status' => 1]);

    // Create ONE work_completion record for this project
    $completion = WorkCompletion::firstOrCreate(
        ['Project_idProject' => $proof->Project_idProject],
        ['completion_date'   => now()]
    );

    // Add each assigned technician to work_completion_technician
    $technicians = AssignTechnician::query()->where('Project_idProject', $proof->Project_idProject)->get();

    foreach ($technicians as $assign) {
        WorkCompletionTechnician::firstOrCreate([
            'work_completion_idwork_completion' => $completion->idwork_completion,
            'user_iduser'                       => $assign->user_iduser,
        ]);
    }

    return redirect()->route('proof_of_work_approval.index')
        ->with('success', 'Project approved successfully!');
}

public function unapprove(Request $request)
{
    $request->validate([
        'idproof_of_work' => 'required|integer',
    ]);

    $proof = ProofOfWork::findOrFail($request->idproof_of_work);

    // Revoke proof approval
    $proof->update(['approval' => 0]);

    // Mark project as not completed
    $proof->project->update(['status' => 0]);

    // Remove all linked additional works
    $proof->additionalWorks()->detach();

    // Delete completion record (cascade deletes technician rows too)
    WorkCompletion::query()->where('Project_idProject', $proof->Project_idProject)->delete();

    return redirect()->route('proof_of_work_approval.index')
        ->with('success', 'Approval revoked successfully!');
}

    public function saveAdditionalWork(Request $request)
    {
        $request->validate([
            'idproof_of_work'                     => 'required|integer',
            'additional_work_idadditional_work'   => 'nullable|array',
            'additional_work_idadditional_work.*' => 'integer',
        ]);

        $proof = ProofOfWork::findOrFail($request->idproof_of_work);

        $proof->additionalWorks()->sync(
            $request->input('additional_work_idadditional_work', [])
        );

        return redirect()->route('proof_of_work_approval.index')
            ->with('success', 'Additional work saved successfully!');
    }
}