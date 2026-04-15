<?php

namespace App\Models\ProjectManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;

class Cancellation extends Model
{
    protected $table = 'cancellation';
    protected $primaryKey = 'idcancellation';
    public $timestamps = false;

    protected $fillable = [
        'Project_idProject',
        'assign_technician_idassign_technician',
        'reason',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'Project_idProject', 'idProject');
    }

    public function assignTechnician()
    {
        return $this->belongsTo(AssignTechnician::class, 'assign_technician_idassign_technician', 'idassign_technician');
    }

        public function User()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }
}