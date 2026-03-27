<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectManagementController extends Controller
{
        public function index(){


        return view('users.components.project_management', ['title' => 'Project Management']);
    }
}
