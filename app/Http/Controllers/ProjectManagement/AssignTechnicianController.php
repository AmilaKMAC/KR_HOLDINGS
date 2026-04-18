<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\ProjectManagement\Cancellation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignTechnicianController extends Controller
{
    // For technician dashboard - show only their assigned projects
    public function index()
    {

        $assignments = AssignTechnician::with([
            'project.Solar',
            'project.Partner',
        ])
            ->where('user_iduser', Auth::id())
            ->where('status', 1)
            ->get();

        return view('users.components.assign_projects', [
            'title' => 'Assign Projects',
            'assignments' => $assignments,
        ]);
    }

    // Store technician assignments
    public function store(Request $request)
    {
        $request->validate([
            'Project_idProject' => 'required|integer',
            'technicians' => 'array',
        ]);

        // Delete old active assignments for this project
        AssignTechnician::where('Project_idProject', $request->Project_idProject)
            ->where('status', 1)
            ->delete();

        // Insert new assignments
        foreach ($request->technicians ?? [] as $techId) {
            AssignTechnician::create([
                'Project_idProject' => $request->Project_idProject,
                'user_iduser' => $techId,
                'status' => 1,
            ]);
        }

        return redirect()->route('project_management.index')
            ->with('success', 'Technicians assigned successfully!');
    }

    // Technician cancels their assigned project
   public function cancel(Request $request)
{

    $request->validate([
        'assign_technician_idassign_technician' => 'required|integer',
        'reason'                                => 'required|string|max:255',
    ]);

    $assignment = AssignTechnician::where('idassign_technician', $request->assign_technician_idassign_technician)
        ->where('user_iduser', Auth::id())
        ->firstOrFail();



    // 1. Save to cancellation table first (before deleting)
    Cancellation::create([
        'Project_idProject'                     => $assignment->Project_idProject,
        'assign_technician_idassign_technician' => $assignment->idassign_technician,
        'reason'                                => $request->reason,
    ]);
    

    // 2. Cancel the Project
$assignment->update(['status' => 0]);

    return redirect()->route('assign_projects.index')
        ->with('success', 'Project cancelled successfully!');
}
}
