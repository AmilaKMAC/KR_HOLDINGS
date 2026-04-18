<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;
use App\Models\ProjectManagement\Project;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'idattendance';
    public $timestamps = false;

    protected $fillable = [
        'user_iduser',
        'attendance',
        'approval',
        'date',
        'project_idProject',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_idProject', 'idProject');
    }
}
