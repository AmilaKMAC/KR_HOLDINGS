<?php

namespace App\Models\ProjectManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\SystemSettings\Solar;
use App\Models\SystemSettings\PartnerCompany;
use App\Models\UserManagement\User;
use App\Models\ProjectManagement\Cancellation;
use App\Models\Proof\WorkCompletion;
use App\Models\SystemSettings\AdditionalWork;


class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'idProject';
    public $timestamps = true;

    protected $fillable = [
        'customer_name',
        'location',
        'site_url',
        'contact',
        'description',
        'solar_idsolar',
        'capacity',
        'partner_company',
        'partner_company_idpartner_company',
        'user_iduser',
        'status',
        
    ];

    public function Solar()
    {
        return $this->belongsTo(Solar::class, 'solar_idsolar', 'idsolar');
    }

    public function Partner()
    {
        return $this->belongsTo(PartnerCompany::class, 'partner_company_idpartner_company', 'idpartner_company');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function assignedTechnicians()
    {
        return $this->hasMany(AssignTechnician::class, 'Project_idProject', 'idProject');
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class, 'Project_idProject', 'idProject');
    }

        public function workCompletion()
    {
        return $this->hasOne(WorkCompletion::class, 'Project_idProject', 'idProject');
    }

    // In Project model:
public function additionalWorks()
{
    return $this->belongsToMany(
        AdditionalWork::class,
        'proof_additional_work',   
        'Project_idProject',      
    );
}
}
