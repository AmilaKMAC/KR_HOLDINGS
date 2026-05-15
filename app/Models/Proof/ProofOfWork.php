<?php

namespace App\Models\Proof;

use App\Models\ProjectManagement\Project;
use App\Models\SystemSettings\AdditionalWork;
use App\Models\UserManagement\User;
use Illuminate\Database\Eloquent\Model;

class ProofOfWork extends Model
{
    protected $table = 'proof_of_work';

    protected $primaryKey = 'idproof_of_work';

    public $timestamps = false;

    protected $fillable = [
        'Project_idProject',
        'user_iduser',
        'approval',
        'unapprove_reason',

    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'Project_idProject', 'idProject');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function images()
    {
        return $this->hasMany(ProofImage::class, 'proof_of_work_idproof_of_work', 'idproof_of_work');
    }

    // Many-to-many via pivot table proof_additional_work
    public function additionalWorks()
    {
        return $this->belongsToMany(
            AdditionalWork::class,
            'proof_additional_work',
            'Project_idProject',
            'idadditional_work'
        );
    }
}
