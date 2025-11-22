<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caregiver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'kinship',
        'full_name',
        'gender',
        'birth_date',
        'cpf',
        'rg',
        'education_level',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'caregiver_contact');
    }
}
