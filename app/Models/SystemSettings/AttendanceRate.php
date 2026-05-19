<?php

namespace App\Models\SystemSettings;

use Illuminate\Database\Eloquent\Model;

class AttendanceRate extends Model
{
    protected $table = 'attendance_rate';
    protected $primaryKey = 'idattendance_rate';
    public $timestamps = false;

    protected $fillable = [
        'rate'
    ];
}
