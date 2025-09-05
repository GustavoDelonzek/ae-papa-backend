<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    protected $fillable = [
        'patient_id',
        'full_name',
        'gender',
        'relationship',
        'birth_date',
        'cpf',
        'rg',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
