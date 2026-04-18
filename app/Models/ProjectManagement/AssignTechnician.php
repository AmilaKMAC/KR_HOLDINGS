<?php

namespace App\Models\ProjectManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;

class AssignTechnician extends Model
{
    protected $table = 'assign_technician';
    protected $primaryKey = 'idassign_technician';
    public $timestamps = false;

    protected $fillable = [
        'Project_idProject',
        'user_iduser',
        'status',
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'Project_idProject', 'idProject');
    }
}
