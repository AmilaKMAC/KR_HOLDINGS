<?php

namespace App\Models\PaymentAndSalary;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;

class Payment extends Model
{
    protected $table      = 'payment';
    protected $primaryKey = 'idpayment';
    public $timestamps    = false;

    protected $fillable = [
        'user_iduser',
        'month',
        'year',
        'basic_salary',
        'other_payment',
        'date',
        'payment_status',
        'total',
        'process_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function paymentProcesses()
    {
        return $this->hasMany(PaymentProcess::class, 'idpayment', 'idpayment');
    }
}