<?php

namespace App\Models\PaymentAndSalary;

use Illuminate\Database\Eloquent\Model;
use App\Models\SystemSettings\AdditionalWork;

class PaymentProcessAdditionalWork extends Model
{
    protected $table      = 'payment_process_additional_work';
    protected $primaryKey = 'id';
    public $timestamps    = true;

    protected $fillable = [
        'payment_process_idpayment_process',
        'additional_work_idadditional_work',
        'rate',
    ];

    public function additionalWork()
    {
        return $this->belongsTo(AdditionalWork::class, 'additional_work_idadditional_work', 'idadditional_work');
    }

    public function paymentProcess()
    {
        return $this->belongsTo(PaymentProcess::class, 'payment_process_idpayment_process', 'idpayment_process');
    }
}