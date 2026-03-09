<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\SystemSettings\TechnicianLevel;


class TechnicianRegistration extends Model
{
    protected $table = 'technician_registration';
    protected $primaryKey = 'idtechnician_registration';


    public function UserRole(){
        return $this->belongsTo(UserRole::class, 'iduser_role');
    }

    public function TechnicianLevel(){
        return $this->belongsTo(TechnicianLevel::class, 'idtechnician_level');
    }       

}
