<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\ProjectManagement\Cancellation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignTechnicianController extends Controller
{
public function index()
{
    $assignments = AssignTechnician::with([
        'project.Solar',
        'project.Partner',
        'project.assignedTechnicians.technician',
    ])
        ->join('project', 'assign_technician.Project_idProject', '=', 'project.idProject')
        ->where('assign_technician.user_iduser', Auth::id())
        ->where('assign_technician.status', 1)
        ->orderBy('project.status', 'asc') // ongoing (0) first, completed (1) last
        ->select('assign_technician.*')    // avoid column conflicts
        ->get();

    return view('users.components.assign_projects', [
        'title'       => 'Assign Projects',
        'assignments' => $assignments,
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'Project_idProject' => 'required|integer',
            'technicians'       => 'array',
        ]);

        // Delete old active assignments for this project
        AssignTechnician::query()->where('Project_idProject', $request->Project_idProject)
            ->where('status', 1)
            ->delete();

        // Insert new assignments
        foreach ($request->technicians ?? [] as $techId) {
            AssignTechnician::create([
                'Project_idProject' => $request->Project_idProject,
                'user_iduser'       => $techId,
                'status'            => 1,
            ]);
        }

        return redirect()->route('project_management.index')
            ->with('success', 'Technicians assigned successfully!');
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'assign_technician_idassign_technician' => 'required|integer',
            'reason'                                => 'required|string|max:255',
        ]);

        $assignment = AssignTechnician::query()->where('idassign_technician', $request->assign_technician_idassign_technician)
            ->where('user_iduser', Auth::id())
            ->firstOrFail();

        // Save to cancellation table
        Cancellation::create([
            'Project_idProject'                     => $assignment->Project_idProject,
            'assign_technician_idassign_technician' => $assignment->idassign_technician,
            'reason'                                => $request->reason,
        ]);

        // Mark assignment as cancelled
        $assignment->update(['status' => 0]);

        return redirect()->route('assign_projects.index')
            ->with('success', 'Project cancelled successfully!');
    }
}