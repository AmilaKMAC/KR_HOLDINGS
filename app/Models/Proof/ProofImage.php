<?php
namespace App\Models\Proof;

use Illuminate\Database\Eloquent\Model;

class ProofImage extends Model
{
    protected $table = 'proof_image';
    protected $primaryKey = 'idproof_image';
    public $timestamps = false;

    protected $fillable = [
        'proof_of_work_idproof_of_work',
        'section',
        'image_path',
    ];

    public function proofOfWork()
    {
        return $this->belongsTo(ProofOfWork::class, 'proof_of_work_idproof_of_work', 'idproof_of_work');
    }
}