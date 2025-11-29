<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use SoftDeletes;
    
    protected $table = 'family_members';

    protected $fillable = [
        'patient_id',
        'full_name',
        'kinship',
        'date_of_birth',
        'occupation',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
