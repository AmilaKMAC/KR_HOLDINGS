<?php

namespace App\Models\userManagement;

use Illuminate\Database\Eloquent\Model;

class TechnicianRegistration extends Model
{
    protected $table = 'technician_registration';
    protected $primaryKey = 'idtechnician_registration';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'nic',
        'contact_number',
        'address',
        'gender',
        'dob',
        'user_role_iduser_role',
        'technician_level_idtechnician_level',
        'username',
        'password',
        'status'
    ];

    protected $hidden = ['password'];
}
