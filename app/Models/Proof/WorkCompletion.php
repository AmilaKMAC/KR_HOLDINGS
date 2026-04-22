<?php
namespace App\Models\Proof;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;
use App\Models\ProjectManagement\Project;

class WorkCompletion extends Model
{
    protected $table = 'work_completion';
    protected $primaryKey = 'idwork_completion';
    public $timestamps = false;

    protected $fillable = [
        'user_iduser',
        'Project_idProject',
        'completion_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'Project_idProject', 'idProject');
    }
}