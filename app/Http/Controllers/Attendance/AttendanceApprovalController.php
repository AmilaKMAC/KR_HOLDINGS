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

    $todayAttendance = Attendance::with(['user.TechnicianRegistration', 'project'])
        ->where('date', $today)
        ->get();

    // Get all attendance history grouped by user
    $allAttendance = Attendance::with(['user.TechnicianRegistration', 'project'])
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('user_iduser');

    return view('users.components.attendance_approval', [
        'title'          => 'Attendance Approval',
        'today'          => $today,
        'todayAttendance' => $todayAttendance,
        'allAttendance'  => $allAttendance,
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
}
