<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalRecord extends Model
{
    protected $table = 'clinical_records';

    protected $fillable = [
        'patient_id',
        'record_date',
        'description',
        'treatment_plan',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
