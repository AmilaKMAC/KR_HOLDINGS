<?php

namespace App\Models\ProjectManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectManagement\Project;
use App\Models\SystemSettings\AdditionalWork;

class ProofAdditionalWork extends Model
{
    protected $table = 'proof_additional_work';
    protected $primaryKey = 'idproof_additional_work';

    protected $fillable = [
        'Project_idProject',
        'idadditional_work',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'Project_idProject', 'idProject');
    }

    public function additionalWork()
    {
        return $this->belongsTo(AdditionalWork::class, 'idadditional_work', 'idadditional_work');
    }
}