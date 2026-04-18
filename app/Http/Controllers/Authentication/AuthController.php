<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\SysLog\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserManagement\User;

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

    // Step 1: Find user by username
    $user = User::where('username', $request->username)->first();

    // Step 2: Check if user exists
    if (!$user) {
        return back()->withErrors([
            'username' => 'Invalid username or password.'
        ]);
    }

    // Step 3: Check if user is active
    if ($user->status != 1) {
        return back()->withErrors([
            'username' => 'User is deactivated. Please contact the System Administrator.'
        ]);
    }

    // Step 4: Attempt login
    if (Auth::attempt([
        'username' => $request->username,
        'password' => $request->password
    ])) {
        $request->session()->regenerate();

        // Log login
        UserActivityLog::create([
            'user_iduser'        => Auth::id(),
            'action_type'        => 'login',
            'module'             => 'auth',
            'action_description' => 'User logged in',
            'ip_address'         => $request->ip(),
            'device'             => $request->userAgent(),
            'login_time'         => now(),
        ]);

        $role = Auth::user()->user_role_iduser_role;

        return match((int)$role) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('executive.dashboard'),
            3 => redirect()->route('coordinator.dashboard'),
            4 => redirect()->route('technician.dashboard'),
            default => redirect()->route('login')
        };
    }

    return back()->withErrors([
        'username' => 'Invalid username or password.'
    ]);
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