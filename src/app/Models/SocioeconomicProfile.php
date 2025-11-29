<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioeconomicProfile extends Model
{
    protected $table = 'socioeconomic_profiles';

    protected $fillable = [
        'patient_id',
        'income_source',
        'housing_ownership',
        'construction_type',
        'sanitation_details',
        'number_of_rooms',
        'number_of_residents',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
