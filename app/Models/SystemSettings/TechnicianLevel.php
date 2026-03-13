<?php

namespace App\Models\SystemSettings;

use Illuminate\Database\Eloquent\Model;

class TechnicianLevel extends Model
{
    protected $table = 'technician_level';
    protected $primaryKey = 'idtechnician_level';
    public $timestamps = false;


    protected $fillable = [
        'idtechnician_level',
        'basic_salary'
    ];

    }


