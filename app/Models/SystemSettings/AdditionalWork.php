<?php

namespace App\Models\SystemSettings;

use Illuminate\Database\Eloquent\Model;

class AdditionalWork extends Model
{
    protected $table = 'additional_work';
    protected $primaryKey = 'idadditional_work';
    public $timestamps = false;

    protected $fillable = [
        'idadditional_work',
        'description',
        'rate'
    ];
}
