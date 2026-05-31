<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\ProjectManagement\Project;
use App\Models\SystemSettings\PartnerCompany;
use App\Models\UserManagement\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $technicianUsers = User::query()->where('user_role_iduser_role', 4)->where('status', 1)->get();

        $technicians = $technicianUsers->map(function ($tech) {
            $assignments = AssignTechnician::with('project.Solar')
                ->where('user_iduser', $tech->iduser)->where('status', 1)->get();

            return [
                'raw_id' => $tech->iduser,
                'name' => $tech->first_name.' '.$tech->last_name,
                'total' => $assignments->count(),
                'completed' => $assignments->filter(fn ($a) => $a->project?->status == 1)->count(),
                'pending' => $assignments->filter(fn ($a) => $a->project?->status == 0)->count(),
                'completed_projects' => $assignments->filter(fn ($a) => $a->project?->status == 1)->values(),
                'pending_projects' => $assignments->filter(fn ($a) => $a->project?->status == 0)->values(),
            ];
        });

        $projects = Project::with(['Solar', 'Partner', 'assignedTechnicians.technician'])
            ->get()->map(fn ($p) => [
                'raw_id' => $p->idProject,
                'customer' => $p->customer_name,
                'location' => $p->location,
                'solar_raw_id' => $p->solar_idsolar,
                'capacity' => optional($p->Solar)->capacity ?? '-',
                'partner' => optional($p->Partner)->company_name ?? '-',
                'technicians' => $p->assignedTechnicians->map(fn ($a) => [
                    'id' => $a->user_iduser,
                    'name' => optional($a->technician)->first_name.' '.optional($a->technician)->last_name,
                ])->values(),
                'status' => $p->status,
                'start_date' => optional($p->created_at)->format('Y-m-d'),
                'end_date' => $p->status == 1 ? optional($p->updated_at)->format('Y-m-d') : '-',
            ]);

        $partners = PartnerCompany::query()->where('status', 1)->get()->map(function ($partner) {
            $pProjects = Project::with('Solar')
                ->where('partner_company_idpartner_company', $partner->idpartner_company)->get();

            return [
                'raw_id' => $partner->idpartner_company,
                'company' => $partner->company_name,
                'total' => $pProjects->count(),
                'completed' => $pProjects->where('status', 1)->count(),
                'ongoing' => $pProjects->where('status', 0)->count(),
                'completed_projects' => $pProjects->where('status', 1)->values()->map(fn ($p) => [
                    'raw_id' => $p->idProject,
                    'customer' => $p->customer_name,
                    'location' => $p->location,
                    'solar_raw_id' => $p->solar_idsolar,
                    'capacity' => optional($p->Solar)->capacity ?? '-',
                    'end_date' => optional($p->updated_at)->format('Y-m-d') ?? '-',
                ]),
                'ongoing_projects' => $pProjects->where('status', 0)->values()->map(fn ($p) => [
                    'raw_id' => $p->idProject,
                    'customer' => $p->customer_name,
                    'location' => $p->location,
                    'solar_raw_id' => $p->solar_idsolar,
                    'capacity' => optional($p->Solar)->capacity ?? '-',
                    'start_date' => optional($p->created_at)->format('Y-m-d') ?? '-',
                ]),
            ];
        });

        $currentMonth = now()->format('Y-m');
        $attendance = $technicianUsers->map(function ($tech) use ($currentMonth) {
            $records = DB::table('attendance')
                ->where('user_iduser', $tech->iduser)
                ->where('approval', 1)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->get();

            $history = DB::table('attendance')
                ->where('user_iduser', $tech->iduser)
                ->where('approval', 1)
                ->orderBy('date')
                ->get()
                ->groupBy(fn ($r) => Carbon::parse($r->date)->format('F Y'))
                ->map(fn ($rows, $month) => [
                    'month' => $month,
                    'present' => $rows->where('attendance', 1)->count(),
                    'absent' => $rows->where('attendance', 0)->count(),
                    'leave' => $rows->whereNotIn('attendance', [0, 1])->count(),
                ])->values();

            return [
                'raw_id' => $tech->iduser,
                'name' => $tech->first_name.' '.$tech->last_name,
                'present' => $records->where('attendance', 1)->count(),
                'absent' => $records->where('attendance', 0)->count(),
                'leave' => $records->whereNotIn('attendance', [0, 1])->count(),
                'month' => now()->format('F Y'),
                'history' => $history,
            ];
        });

        return view('users.components.reports', compact(
            'technicians', 'projects', 'partners', 'attendance'
        ) + ['title' => 'Reports']);
    }
}
