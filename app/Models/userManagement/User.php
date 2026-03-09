<?php

namespace App\Models\userManagement;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'iduser';

    public function UserRegistration()
    {
        return $this->belongsTo(UserRegistration::class, 'iduser_registration');
    }
  
    public function TechnicianRegistration()
    {
        return $this->belongsTo(TechnicianRegistration::class, 'idtechnician_registration');
    }
    

    public function UserRole(){
        return $this->belongsTo(UserRole::class, 'iduser_role');
    }


}
