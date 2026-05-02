<?php

namespace App\Models\Proof;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserManagement\User;

class WorkCompletionTechnician extends Model
{
    protected $table = 'work_completion_technician';
    protected $primaryKey = 'idwork_completion_technician';

    protected $fillable = [
        'work_completion_idwork_completion',
        'user_iduser',
    ];

    public function workCompletion()
    {
        return $this->belongsTo(WorkCompletion::class, 'work_completion_idwork_completion', 'idwork_completion');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }
}