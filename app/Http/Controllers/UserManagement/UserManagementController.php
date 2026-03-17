<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\UserManagement\TechnicianRegistration;
use App\Models\UserManagement\User;
use App\Models\UserManagement\UserRegistration;
use App\Models\UserManagement\UserRole;
use App\Models\SystemSettings\TechnicianLevel; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $users = User::with(['UserRole', 'UserRegistration'])
            ->whereIn('user_role_iduser_role', [1, 2, 3])
            ->get();

        $technicians = User::with(['UserRole', 'TechnicianRegistration'])
            ->whereIn('user_role_iduser_role', [4])
            ->get();

        $roles = UserRole::whereIn('iduser_role', [1, 2, 3])->get();

        $technicianLevels = TechnicianLevel::all(); // added

        return view('users.components.user_management',
            compact('users', 'technicians', 'roles', 'technicianLevels'),
            ['title' => 'User Management']
        );
    }

    // ================= STORE USER =================
    public function store(Request $request)
    {
        $request->validate([
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'nullable|string|max:100',
            'nic'                   => 'required|string|max:12|unique:user,nic',
            'dob'                   => 'nullable|date',
            'address'               => 'required|string|max:200',
            'contact_no'            => 'nullable|digits:10',
            'gender'                => 'nullable|string',
            'start_date'            => 'nullable|date',
            'user_role_iduser_role' => 'required|integer',
            'status'                => 'required|integer',
            'username'              => 'required|string|max:100|unique:user,username',
            'password'              => 'required|string|min:6',
        ]);

        $userRegistration = UserRegistration::create([
            'user_role_iduser_role' => $request->user_role_iduser_role,
        ]);

        User::create([
            'first_name'                            => $request->first_name,
            'last_name'                             => $request->last_name,
            'nic'                                   => $request->nic,
            'dob'                                   => $request->dob,
            'address'                               => $request->address,
            'contact_no'                            => $request->contact_no,
            'gender'                                => $request->gender,
            'created_at'                            => $request->start_date,
            'user_role_iduser_role'                 => $request->user_role_iduser_role,
            'user_registration_iduser_registration' => $userRegistration->iduser_registration,
            'status'                                => $request->status,
            'username'                              => $request->username,
            'password'                              => Hash::make($request->password),
        ]);

        return redirect()->route('userManagement.index')->with('success', 'User added successfully!');
    }

    // ================= UPDATE USER =================
    public function update(Request $request, $id)
    {
        $user = User::where('iduser', $id)->firstOrFail();

        $request->validate([
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'nullable|string|max:100',
            'nic'                   => 'required|string|max:12|unique:user,nic,'.$id.',iduser',
            'dob'                   => 'required|date',
            'address'               => 'required|string|max:200',
            'contact_no'            => 'required|string|max:10',
            'gender'                => 'required|string',
            'user_role_iduser_role' => 'required|integer',
            'status'                => 'required|integer',
            'username'              => 'required|string|max:100|unique:user,username,'.$id.',iduser',
        ]);

        $data = [
            'first_name'            => $request->first_name,
            'last_name'             => $request->last_name,
            'nic'                   => $request->nic,
            'dob'                   => $request->dob,
            'address'               => $request->address,
            'contact_no'            => $request->contact_no,
            'gender'                => $request->gender,
            'user_role_iduser_role' => $request->user_role_iduser_role,
            'status'                => $request->status,
            'username'              => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('userManagement.index')->with('success', 'User updated successfully!');
    }

    // ================= STORE TECHNICIAN =================
    public function storeTechnician(Request $request)
    {
        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'nullable|string|max:100',
            'nic'              => 'required|string|max:12|unique:user,nic',
            'dob'              => 'required|date',
            'address'          => 'required|string|max:200',
            'contact_no'       => 'required|string|max:10',
            'gender'           => 'required|string',
            'start_date'       => 'required|date',
            'experience_level' => 'required|integer',
            'status'           => 'required|integer',
            'username'         => 'required|string|max:100|unique:user,username',
            'password'         => 'required|string|min:1',
        ]);

        $techRegistration = TechnicianRegistration::create([
            'user_role_iduser_role'               => 4,
            'technician_level_idtechnician_level' => $request->experience_level,
        ]);

        User::create([
            'first_name'                                        => $request->first_name,
            'last_name'                                         => $request->last_name,
            'nic'                                               => $request->nic,
            'dob'                                               => $request->dob,
            'address'                                           => $request->address,
            'contact_no'                                        => $request->contact_no,
            'gender'                                            => $request->gender,
            'created_at'                                        => $request->start_date,
            'user_role_iduser_role'                             => 4,
            'technician_registration_idtechnician_registration' => $techRegistration->idtechnician_registration,
            'status'                                            => $request->status,
            'username'                                          => $request->username,
            'password'                                          => Hash::make($request->password),
        ]);

        return redirect()->route('userManagement.index')->with('success', 'Technician added successfully!');
    }

    // ================= UPDATE TECHNICIAN =================
    public function updateTechnician(Request $request, $id)
    {
        $technician = User::where('iduser', $id)->firstOrFail();

        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'nullable|string|max:100',
            'nic'              => 'required|string|max:12|unique:user,nic,'.$id.',iduser',
            'dob'              => 'required|date',
            'address'          => 'required|string|max:200',
            'contact_no'       => 'required|string|max:10',
            'gender'           => 'required|string',
            'experience_level' => 'required|integer',
            'status'           => 'required|integer',
            'username'         => 'required|string|max:100|unique:user,username,'.$id.',iduser',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'nic'        => $request->nic,
            'dob'        => $request->dob,
            'address'    => $request->address,
            'contact_no' => $request->contact_no,
            'gender'     => $request->gender,
            'status'     => $request->status,
            'username'   => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $technician->update($data);

        // Also update the technician registration level
        $technician->TechnicianRegistration?->update([
            'technician_level_idtechnician_level' => $request->experience_level,
        ]);

        return redirect()->route('userManagement.index')->with('success', 'Technician updated successfully!');
    }
}