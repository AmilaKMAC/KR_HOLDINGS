<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\SysLog\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('users.signin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status'   => 1,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Log the login
            UserActivityLog::create([
                'user_iduser'        => Auth::id(),
                'action_type'        => 'login',
                'module'             => 'auth',
                'action_description' => 'User logged in',
                'ip_address'         => $request->ip(),
                'device'             => $request->userAgent(),
                'login_time'         => now(),
            ]);

            // Redirect based on role
            $role = Auth::user()->user_role_iduser_role;

            return match((int)$role) {
                1 => redirect()->route('admin.dashboard'),
                2 => redirect()->route('executive.dashboard'),
                3 => redirect()->route('coordinator.dashboard'),
                4 => redirect()->route('technician.dashboard'),
                default => redirect()->route('login')
            };
        }

        return back()->withErrors(['username' => 'Invalid credentials or account inactive.']);
    }

    public function logout(Request $request)
    {
        // Update logout time in log
        UserActivityLog::where('user_iduser', Auth::id())
            ->whereNull('logout_time')
            ->latest('login_time')
            ->first()
            ?->update(['logout_time' => now()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
