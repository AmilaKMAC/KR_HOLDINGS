<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
                   public function index(){


        return view('users.dashboard.technician', ['title' => 'Dashboard']);
    }
}
