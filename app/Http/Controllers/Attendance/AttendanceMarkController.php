<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceMarkController extends Controller
{
        public function index(){


        return view('users.components.attendance', ['title' => 'Attendance']);
    }
}
