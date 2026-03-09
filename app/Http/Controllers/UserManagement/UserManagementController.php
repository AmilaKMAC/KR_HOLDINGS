<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserManagement\User;

class UserManagementController extends Controller
{    public function index(){
        $users = User::whereIn('user_role_iduser_role', [1,2,3])->get();

        $technicians = User::whereIn('user_role_iduser_role', [4])->get();

        return view('users.components.user_management', [
            'title'=>'User Management', 
            'users' => $users,
            'technicians' => $technicians
        ]);


    }
}
