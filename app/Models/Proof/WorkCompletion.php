<?php

namespace App\Models\Proof;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectManagement\Project;

class WorkCompletion extends Model
{
    protected $table = 'work_completion';
    protected $primaryKey = 'idwork_completion';

    protected $fillable = [
        'Project_idProject',
        'completion_date',
                'approval',

    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'Project_idProject', 'idProject');
    }

    public function technicians()
    {
        return $this->hasMany(WorkCompletionTechnician::class, 'work_completion_idwork_completion', 'idwork_completion');
    }

        public function images()
    {
        return $this->hasMany(WorkCompletionTechnician::class, 'work_completion_idwork_completion', 'idwork_completion');
    }

}