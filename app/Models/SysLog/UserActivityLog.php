<?php

namespace App\Models\SysLog;

use Illuminate\Database\Eloquent\Model;
use app\Models\UserManagement\User;

class UserActivityLog extends Model
{
    protected $table = 'user_activity_logs';
    protected $primaryKey = 'iduser_activity_logs';
    public $timestamps = false;

    protected $fillable = [
        'user_iduser',
        'action_type',
        'module',
        'record_id',
        'action_description',
        'old_values',
        'new_values',
        'ip_address',
        'device',
        'login_time',
        'logout_time',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }
}
