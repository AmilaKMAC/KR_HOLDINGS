<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\ProjectManagement\Project;
   use Illuminate\Support\Facades\Auth;


class AssignTechnicianController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'Project_idProject' => 'required|integer',
            'technicians'       => 'array',
        ]);

        // Delete old assignments for this project
        AssignTechnician::where('Project_idProject', $request->Project_idProject)->delete();

        // Insert new assignments
        foreach ($request->technicians ?? [] as $techId) {
            AssignTechnician::create([
                'Project_idProject' => $request->Project_idProject,
                'user_iduser'       => $techId,
            ]);
        }

        return redirect()->route('project_management.index')
            ->with('success', 'Technicians assigned successfully!');
    }


public function index()
{
    $projects = Project::with([
        'Solar',
        'Partner',
        'assignedTechnicians.technician',
    ])->whereHas('assignedTechnicians', function ($query) {
        $query->where('user_iduser', Auth::id());
    })->get();

    return view('users.components.assign_projects', [
        'title'    => 'Assign Projects',
        'projects' => $projects,
    ]);
}
}
