<?php

namespace App\Models\PaymentAndSalary;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;
use App\Models\SystemSettings\TechnicianLevel;
use App\Models\ProjectManagement\Project;
use App\Models\PaymentAndSalary\PaymentProcessAdditionalWork;

class PaymentProcess extends Model
{
    protected $table      = 'payment_process';
    protected $primaryKey = 'idpayment_process';
    public $timestamps    = false;

    protected $fillable = [
        'user_iduser',
        'idpayment',
        'project_idProject',
        'technician_level_idtechnician_level',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'idpayment', 'idpayment');
    }

    public function technicianLevel()
    {
        return $this->belongsTo(TechnicianLevel::class, 'technician_level_idtechnician_level', 'idtechnician_level');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_idProject', 'idProject');
    }

    public function additionalWorks()
    {
        return $this->hasMany(PaymentProcessAdditionalWork::class, 'payment_process_idpayment_process', 'idpayment_process');
    }
}