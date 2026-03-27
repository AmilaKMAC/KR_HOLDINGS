<?php

namespace App\Http\Controllers\TechnicianPerformance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechnicianPerformanceController extends Controller
{
       public function index(){
        

        return view('users.components.technician_performance', ['title' => 'Technician Performance']);
    }

}
