<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\Proof\ProofOfWork;
use App\Models\Proof\WorkCompletion;
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
            'additionalWork',
        ])->where('approval', 0)->get();

        $approved = ProofOfWork::with([
            'project.Solar',
            'project.Partner',
            'project.assignedTechnicians.technician',
            'images',
            'additionalWork',
        ])->where('approval', 1)->get();

        $additionalWorkOptions = AdditionalWork::all();

        return view('users.components.proof_of_work_approval', [
            'pending' => $pending,
            'approved' => $approved,
            'additionalWorkOptions' => $additionalWorkOptions,
            'title' => 'Proof of Work Approval',
        ]);
    }

    public function approve(Request $request)
    {
        $request->validate([
            'idproof_of_work' => 'required|integer',
            'additional_work_idadditional_work' => 'nullable|integer',
        ]);

        $proof = ProofOfWork::findOrFail($request->idproof_of_work);

        $proof->update([
            'approval' => 1,
            'additional_work_idadditional_work' => $request->additional_work_idadditional_work,
        ]);

        // Fill work_completion for every assigned technician on this project
        $technicians = AssignTechnician::where('Project_idProject', $proof->Project_idProject)->get();

        foreach ($technicians as $assign) {
            WorkCompletion::firstOrCreate(
                [
                    'user_iduser' => $assign->user_iduser,
                    'Project_idProject' => $proof->Project_idProject,
                ],
                [
                    'completion_date' => now()->format('Y-m-d'),
                ]
            );
        }

        return redirect()->route('proof_of_work_approval.index')
            ->with('success', 'Project approved and completion recorded!');
    }

    public function unapprove(Request $request)
    {
        $request->validate([
            'idproof_of_work' => 'required|integer',
        ]);

        // Set approval back to 0 so technician must re-upload
        ProofOfWork::findOrFail($request->idproof_of_work)
            ->update(['approval' => 0]);

        // Remove work completion records for this project
        WorkCompletion::where('Project_idProject',
            ProofOfWork::find($request->idproof_of_work)?->Project_idProject
        )->delete();

        return redirect()->route('proof_of_work_approval.index')
            ->with('success', 'Approval revoked. Technician must re-upload.');
    }
}
