<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        return view('users.components.log_reports', [
            'title' => 'Log Reports',
            'role'  => Auth::user()->user_role_iduser_role,
        ]);
    }

}
