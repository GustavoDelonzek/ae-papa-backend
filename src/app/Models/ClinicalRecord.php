<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicalRecord extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'clinical_records';

    protected $fillable = [
        'patient_id',
        'diagnosis_date',
        'disease_stage',
        'comorbidities',
        'responsible_doctor',
        'health_unit_location',
        'medications_usage',
        'recognizes_family',
        'emotional_state',
        'wandering_risk',
        'verbal_communication',
        'disorientation_frequency',
        'has_falls_history',
        'needs_feeding_help',
        'needs_hygiene_help',
        'has_sleep_issues',
        'has_hallucinations',
        'reduced_mobility',
        'is_aggressive',
    ];


    protected $casts = [
        'comorbidities' => 'array',
        'diagnosis_date' => 'date',
        'wandering_risk' => 'boolean',
        'verbal_communication' => 'boolean',
        'disorientation_frequency' => 'boolean',
        'has_falls_history' => 'boolean',
        'needs_feeding_help' => 'boolean',
        'needs_hygiene_help' => 'boolean',
        'has_sleep_issues' => 'boolean',
        'has_hallucinations' => 'boolean',
        'reduced_mobility' => 'boolean',
        'is_aggressive' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
