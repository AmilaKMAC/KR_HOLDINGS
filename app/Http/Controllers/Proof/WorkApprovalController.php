<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkApprovalController extends Controller
{
            public function index(){


        return view('users.components.proof_of_work_approval', ['title' => 'Proof of Work Approval']);
    }
}
