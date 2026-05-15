<?php
namespace App\Models\UserManagement;
use Illuminate\Database\Eloquent\Model;
use App\Models\SystemSettings\TechnicianLevel;

class TechnicianRegistration extends Model
{
    protected $table = 'technician_registration';
    protected $primaryKey = 'idtechnician_registration';
    public $timestamps = false;

    protected $fillable = [
        'user_role_iduser_role',
        'technician_level_idtechnician_level'
    ];

    public function technicianLevel()
{
    return $this->belongsTo(
        TechnicianLevel::class,
        'technician_level_idtechnician_level',
        'idtechnician_level'
    );
}


}