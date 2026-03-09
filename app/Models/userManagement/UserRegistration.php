<?php

namespace App\Models\userManagement;

use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    protected $table = 'user_registration';
    protected $primaryKey = 'iduser_registration';


    public function UserRole(){
        return $this->belongsTo(UserRole::class, 'iduser_role');
    }
}
