<?php

namespace App\Http\Controllers\TechnicianPerformance;

use App\Http\Controllers\Controller;
use App\Models\UserManagement\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechnicianPerformanceController extends Controller
{
    public function index()
    {
        $technicianUsers = User::where('user_role_iduser_role', 4)
            ->where('status', 1)->get();

        $currentMonth = now()->format('Y-m');
        $timeFrame    = now()->format('M Y');

        // ── Completion of Work ────────────────────────────────────────────
        $completionRows = [];

        foreach ($technicianUsers as $tech) {
            $completions = DB::table('work_completion_technician as wct')
                ->join('work_completion as wc', 'wct.work_completion_idwork_completion', '=', 'wc.idwork_completion')
                ->join('project as p', 'wc.Project_idProject', '=', 'p.idProject')
                ->join('solar as s', 'p.solar_idsolar', '=', 's.idsolar')
                ->where('wct.user_iduser', $tech->iduser)
                ->where('wc.approval', 1)
                ->whereRaw("DATE_FORMAT(wc.completion_date, '%Y-%m') = ?", [$currentMonth])
                ->select('p.idProject', 'p.customer_name', 'p.location', 'p.solar_idsolar', 's.capacity', 'wc.completion_date')
                ->get();

            foreach ($completions as $c) {
                $completionRows[] = [
                    'tech_id'         => $tech->iduser,
                    'tech_name'       => $tech->first_name . ' ' . $tech->last_name,
                    'project_id'      => $c->idProject,
                    'customer'        => $c->customer_name,
                    'location'        => $c->location,
                    'solar_id'        => $c->solar_idsolar,
                    'capacity'        => $c->capacity,
                    'completion_date' => $c->completion_date,
                ];
            }
        }

        // ── Completion Rate ───────────────────────────────────────────────
        $completionRates = [];

        foreach ($technicianUsers as $tech) {
            $assigned = DB::table('assign_technician')
                ->where('user_iduser', $tech->iduser)
                ->where('status', 1)
                ->count();

            $completed = DB::table('work_completion_technician as wct')
                ->join('work_completion as wc', 'wct.work_completion_idwork_completion', '=', 'wc.idwork_completion')
                ->where('wct.user_iduser', $tech->iduser)
                ->where('wc.approval', 1)
                ->whereRaw("DATE_FORMAT(wc.completion_date, '%Y-%m') = ?", [$currentMonth])
                ->distinct('wc.Project_idProject')
                ->count('wc.Project_idProject');

            $rate = $assigned > 0 ? round(($completed / $assigned) * 100) : 0;

            $completionRates[] = [
                'tech_id'    => $tech->iduser,
                'tech_name'  => $tech->first_name . ' ' . $tech->last_name,
                'assigned'   => $assigned,
                'completed'  => $completed,
                'rate'       => $rate . '%',
                'time_frame' => $timeFrame,
            ];
        }

        // ── Attendance Reliability ────────────────────────────────────────
        $attendanceRows = [];

        foreach ($technicianUsers as $tech) {
            $records = DB::table('attendance')
                ->where('user_iduser', $tech->iduser)
                ->where('approval', 1)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->get();

            $totalWorkdays = $records->count();
            $presentDays   = $records->where('attendance', 1)->count();
            $reliability   = $totalWorkdays > 0 ? round(($presentDays / $totalWorkdays) * 100) : 0;

            $attendanceRows[] = [
                'tech_id'      => $tech->iduser,
                'tech_name'    => $tech->first_name . ' ' . $tech->last_name,
                'total_days'   => $totalWorkdays,
                'present_days' => $presentDays,
                'reliability'  => $reliability . '%',
                'time_frame'   => $timeFrame,
            ];
        }

        return view('users.components.technician_performance', [
            'title'           => 'Technician Performance',
            'completionRows'  => $completionRows,
            'completionRates' => $completionRates,
            'attendanceRows'  => $attendanceRows,
        ]);
    }
}