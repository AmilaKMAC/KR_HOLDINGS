<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance\Attendance;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectManagement\AssignTechnician;



class AttendanceMarkController extends Controller
{
public function index()
    {
        $today = now()->format('Y-m-d');

        $todayAttendance = Attendance::where('user_iduser', Auth::id())
            ->where('date', $today)
            ->first();

        // Get only active assigned projects for this technician
        $assignedProjects = AssignTechnician::with('project.Solar')
            ->where('user_iduser', Auth::id())
            ->where('status', 1)
            ->get();

        return view('users.components.attendance', [
            'title'            => 'Attendance',
            'today'            => $today,
            'todayAttendance'  => $todayAttendance,
            'assignedProjects' => $assignedProjects,
        ]);
    }

    public function mark(Request $request)
    {
        $request->validate([
            'project_idProject' => 'required|integer',
        ]);

        $today = now()->format('Y-m-d');

        $existing = Attendance::where('user_iduser', Auth::id())
            ->where('date', $today)
            ->first();

        if ($existing) {
            return redirect()->route('attendance.index')
                ->with('error', 'Attendance already marked for today!');
        }

        Attendance::create([
            'user_iduser'        => Auth::id(),
            'attendance'         => 1,
            'approval'           => 0,
            'date'               => $today,
            'project_idProject'  => $request->project_idProject,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }
}

