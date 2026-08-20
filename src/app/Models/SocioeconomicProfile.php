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

    public function getIncomeSourceLabelAttribute(): string
    {
        $raw = $this->income_source;

        if (!$raw) {
            return '';
        }

        $parsed = is_string($raw) ? json_decode($raw, true) : $raw;

        if (!is_array($parsed)) {
            return (string) $raw;
        }

        $category = (string) data_get($parsed, 'category', '');
        $other = data_get($parsed, 'other');

        return $other ? trim($category . ' (' . $other . ')') : $category;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
