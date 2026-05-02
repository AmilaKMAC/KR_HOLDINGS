<?php

namespace App\Console\Commands;

use App\Models\Attendance\Attendance;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\UserManagement\User;
use Illuminate\Console\Command;

class MarkAbsentTechnicians extends Command
{
    protected $signature   = 'attendance:mark-absent';
    protected $description = 'Auto-mark absent for technicians who did not mark attendance today';

    public function handle(): void
    {
        $today = now()->toDateString();

        $technicians = User::query()                          
            ->where('user_role_iduser_role', 4)
            ->where('status', 1)
            ->get();

        $marked = 0;

        foreach ($technicians as $technician) {
            $alreadyMarked = Attendance::query()             // ✅ Fix line 26
                ->where('user_iduser', $technician->iduser)
                ->where('date', $today)
                ->exists();

            if ($alreadyMarked) continue;

            $assigned = AssignTechnician::query()           
                ->where('user_iduser', $technician->iduser)
                ->where('status', 1)
                ->latest('idassign_technician')
                ->first();


            Attendance::create([
                'user_iduser'       => $technician->iduser,
                'attendance'        => 0,
                'approval'          => 0,
                'date'              => $today,
                'project_idProject' => $assigned?->Project_idProject ?? null,
            ]);

            $marked++;
        }

        $this->info("Done. {$marked} technician(s) marked absent.");
    }
}