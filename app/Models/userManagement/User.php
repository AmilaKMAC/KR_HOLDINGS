<?php

namespace App\Models\UserManagement;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'iduser';
    public $timestamps = false;
    protected $casts = ['created_at' => 'datetime'];

    protected $hidden = ['password'];

    protected $fillable = [
        'first_name',
        'last_name',
        'nic',
        'dob',
        'address',
        'contact_no',
        'gender',
        'created_at',
        'username',
        'password',
        'status',
        'user_role_iduser_role',
        'user_registration_iduser_registration',
        'technician_registration_idtechnician_registration',
    ];

    // Tell Laravel to use 'username' instead of 'email' for auth
    public function getAuthIdentifierName() { return 'iduser'; }
    public function getAuthPassword()       { return $this->password; }

    public function UserRegistration() {
        return $this->belongsTo(UserRegistration::class, 'user_registration_iduser_registration', 'iduser_registration');
    }

    public function TechnicianRegistration() {
        return $this->belongsTo(TechnicianRegistration::class, 'technician_registration_idtechnician_registration', 'idtechnician_registration');
    }

    public function UserRole() {
        return $this->belongsTo(UserRole::class, 'user_role_iduser_role', 'iduser_role');
    }
}