<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance\Attendance;
use App\Models\UserManagement\User;


class AttendanceApprovalController extends Controller
{
public function index()
{
    $today = now()->format('Y-m-d');

    $technicians = User::with([
        'TechnicianRegistration',
        'assignedProjects.project',
    ])
    ->where('user_role_iduser_role', 4)
    ->where('status', 1)
    ->get();

    // Today's attendance keyed by user_iduser
    $todayAttendance = Attendance::with(['project'])
        ->whereIn('user_iduser', $technicians->pluck('iduser'))
        ->where('date', $today)
        ->get()
        ->keyBy('user_iduser');

    // ALL attendance history including today grouped by user_iduser
    // for summary counts in history table
    $allAttendance = Attendance::with(['project'])
        ->whereIn('user_iduser', $technicians->pluck('iduser'))
        ->where('date', '<=', $today)  // include today
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('user_iduser');

    // Past attendance only (excluding today) for history modal detail
    $pastAttendance = Attendance::with(['project'])
        ->whereIn('user_iduser', $technicians->pluck('iduser'))
        ->where('date', '<', $today)
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('user_iduser');

    return view('users.components.attendance_approval', [
        'title'           => 'Attendance Approval',
        'today'           => $today,
        'technicians'     => $technicians,
        'todayAttendance' => $todayAttendance,
        'allAttendance'   => $allAttendance,
        'pastAttendance'  => $pastAttendance,
    ]);
}

    public function approve(Request $request)
    {
        $request->validate([
            'idattendance' => 'required|integer',
            'approval'     => 'required|in:0,1',
        ]);

        Attendance::findOrFail($request->idattendance)
            ->update(['approval' => $request->approval]);

        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }

    public function history($userId)
    {
        $attendances = Attendance::with('project')
            ->where('user_iduser', $userId)
            ->orderBy('date', 'desc')
            ->get();

        $user = User::findOrFail($userId);

        return response()->json([
            'user'        => $user->first_name . ' ' . $user->last_name,
            'attendances' => $attendances->map(function ($a) {
                return [
                    'idattendance' => $a->idattendance,
                    'date'         => $a->date,
                    'attendance'   => $a->attendance,
                    'approval'     => $a->approval,
                    'project'      => $a->project?->customer_name ?? 'N/A',
                    'location'     => $a->project?->location ?? 'N/A',
                ];
            }),
        ]);
    }

    public function manualMark(Request $request)
    {
        $request->validate([
            'user_iduser'       => 'required|integer',
            'project_idProject' => 'required|integer',
            'date'              => 'required|date',
            'attendance'        => 'required|in:0,1',
        ]);

        $existing = Attendance::where('user_iduser', $request->user_iduser)
            ->where('date', $request->date)
            ->first();

        if ($existing) {
            $existing->update([
                'attendance'        => $request->attendance,
                'project_idProject' => $request->project_idProject,
                'approval'          => 1,
            ]);
            return redirect()->back()->with('success', 'Attendance updated!');
        }

        Attendance::create([
            'user_iduser'       => $request->user_iduser,
            'attendance'        => $request->attendance,
            'approval'          => 1,
            'date'              => $request->date,
            'project_idProject' => $request->project_idProject,
        ]);

        return redirect()->back()->with('success', 'Attendance marked!');
    }
}