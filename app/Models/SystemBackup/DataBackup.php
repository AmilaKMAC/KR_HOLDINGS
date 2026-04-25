<?php

namespace App\Models\SystemBackup;

use Illuminate\Database\Eloquent\Model;

class DataBackup extends Model
{
    protected $table = 'data_backups';
    protected $primaryKey = 'iddata_backups';
    public $timestamps = false;

    protected $fillable = [
        'backup_type',
        'backup_category',
        'backup_date',
        'file_path',
        'file_size',
        'status',
        'error_message',
        'completion_time',
    ];
}