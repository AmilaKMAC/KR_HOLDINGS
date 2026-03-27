<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignProjectController extends Controller
{
            public function index(){


        return view('users.components.assign_projects', ['title' => 'Assign Projects']);
    }
}
