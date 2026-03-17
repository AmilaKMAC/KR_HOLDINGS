<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    protected $table = 'user_registration';
    protected $primaryKey = 'iduser_registration';
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'user_registration_iduser_registration');
    }

    protected $fillable = [
        'user_role_iduser_role',
    ];
}
