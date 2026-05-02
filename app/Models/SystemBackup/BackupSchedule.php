<?php

namespace App\Models\SystemBackup;

use Illuminate\Database\Eloquent\Model;

class BackupSchedule extends Model
{
    protected $table = 'backup_schedule';
    protected $primaryKey = 'idbackup_schedule';

    protected $fillable = [
        'backup_type',
        'backup_category',
        'frequency',
        'schedule_time',
        'last_run',
        'next_run',
        'retention_date',
    ];

    protected $casts = [
        'schedule_time'  => 'datetime',
        'last_run'       => 'datetime',
        'next_run'       => 'datetime',
        'retention_date' => 'datetime',
    ];
}
