<?php

namespace App\Models\userManagement;

use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    protected $table = 'user_registration';
    protected $primaryKey = 'iduser_registration';
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
        'username',
        'password',
        'status'
    ];

    protected $hidden = ['password'];
}
