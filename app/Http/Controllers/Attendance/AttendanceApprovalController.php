<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceApprovalController extends Controller
{
        public function index(){


        return view('users.components.attendance_approval', ['title' => 'Attendance Approval']);
    }
}
