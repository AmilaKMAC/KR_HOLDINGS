<?php

namespace App\Models\SystemSettings;

use Illuminate\Database\Eloquent\Model;

class Solar extends Model
{
    protected $table= 'solar';
    protected $primaryKey = 'idsolar';
    public $timestamps = false;

    protected $fillable = [
        'idsolar',
        'capacity',
        'rate'
    ];
}
