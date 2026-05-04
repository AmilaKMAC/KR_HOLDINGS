<?php

namespace App\Models\PaymentAndSalary;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;
use App\Models\SystemSettings\Solar;
use App\Models\SystemSettings\AdditionalWork;
use App\Models\SystemSettings\TechnicianLevel;

class PaymentProcess extends Model
{
    protected $table      = 'payment_process';
    protected $primaryKey = 'idpayment_process';
    public $timestamps    = false;

    protected $fillable = [
        'user_iduser',
        'idpayment',
        'technician_level_idtechnician_level',
        'solar_idsolar',
        'additional_work_idadditional_work',
        'others',
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

    public function solar()
    {
        return $this->belongsTo(Solar::class, 'solar_idsolar', 'idsolar');
    }

    public function additionalWork()
    {
        return $this->belongsTo(AdditionalWork::class, 'additional_work_idadditional_work', 'idadditional_work');
    }
}