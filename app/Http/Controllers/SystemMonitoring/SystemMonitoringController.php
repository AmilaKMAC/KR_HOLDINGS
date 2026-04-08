<?php

namespace App\Http\Controllers\SystemMonitoring;

use App\Http\Controllers\Controller;
use App\Models\SysLog\UserActivityLog;
use App\Models\UserManagement\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemMonitoringController extends Controller
{
    public function index()
    {
        $active_users = User::with([
            'UserRole',
            'UserRegistration',
            'TechnicianRegistration',
        ])->get()->map(function ($user) {

            $lastLog = UserActivityLog::where('user_iduser', $user->iduser)
                ->latest('login_time')
                ->first();

            $user->login_time  = $lastLog?->login_time;
            $user->logout_time = $lastLog?->logout_time;
            $user->ip_address  = $lastLog?->ip_address ?? 'N/A';
            $user->device      = $lastLog?->device ?? 'N/A';
            $user->is_online   = $lastLog && $lastLog->logout_time == null;

            return $user;
        });

        return view('users.components.system_monitoring', [
            'title'        => 'System Monitoring',
            'active_users' => $active_users,
        ]);
    }

    public function forceLogout($id)
    {
        $log = UserActivityLog::where('user_iduser', $id)
            ->whereNull('logout_time')
            ->latest('login_time')
            ->first();

        if ($log) {
            $log->update(['logout_time' => now()]);
        }

        return redirect()->back()->with('success', 'User logged out successfully!');
    }
}