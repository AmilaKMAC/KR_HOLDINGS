<?php
namespace App\Models\UserManagement;
use Illuminate\Database\Eloquent\Model;

class TechnicianRegistration extends Model
{
    protected $table = 'technician_registration';
    protected $primaryKey = 'idtechnician_registration';
    public $timestamps = false;

    protected $fillable = [
        'user_role_iduser_role',
        'technician_level_idtechnician_level'
    ];
}