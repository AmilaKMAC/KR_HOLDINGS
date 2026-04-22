<?php
namespace App\Models\Proof;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectManagement\Project;
use App\Models\SystemSettings\PartnerCompany;
use App\Models\SystemSettings\Solar;
use App\Models\UserManagement\User;

class ProofOfWork extends Model
{
    protected $table = 'proof_of_work';
    protected $primaryKey = 'idproof_of_work';
    public $timestamps = false;

    protected $fillable = [
        'Project_idProject',
        'user_iduser',
        'approval',
        'additional_work_idadditional_work',
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

    public function additionalWork()
    {
        return $this->belongsTo(\App\Models\SystemSettings\AdditionalWork::class, 'additional_work_idadditional_work', 'idadditional_work');
    }
}