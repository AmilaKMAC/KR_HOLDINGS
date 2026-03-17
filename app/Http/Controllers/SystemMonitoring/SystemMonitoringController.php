<?php

namespace App\Http\Controllers\SystemMonitoring;

use App\Http\Controllers\Controller;
use App\Models\SysLog\UserActivityLog;
use Illuminate\Http\Request;

class SystemMonitoringController extends Controller
{
    public function index(){
        $active_users = UserActivityLog::with('User')->get();

        return view('users.components.system_monitoring', ['title' => 'System Monitoring', 'active_users' => $active_users]);
    }



// Store Active Users
public function storeActiveUsers(Request $request){
        UserActivityLog::create([
            'ip_address' => $request->ip(),
            'device' => $request->userAgent(),
            'login_time' => $request->login_time,
            'logout_time' => $request->logout_time,
        ]);

        return redirect()->route('system_monitoring.index')->with('success', 'User added successfully!');
    }



}


