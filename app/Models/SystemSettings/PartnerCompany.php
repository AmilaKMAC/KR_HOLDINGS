<?php

namespace App\Models\SystemSettings;

use Illuminate\Database\Eloquent\Model;

class PartnerCompany extends Model
{
    protected $table = 'partner_company';
    protected $primaryKey = 'idpartner_company';
    

    protected $fillable = [
        'idpartner_company',        
        'company_name',
        'status',
        'created_at',
    ];
}
