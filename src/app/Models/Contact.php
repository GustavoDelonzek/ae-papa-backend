<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    protected $fillable = [
        'type',
        'value',
        'is_primary',
    ];

    public function patient(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'contact_patient');
    }

    public function caregiver(): BelongsToMany
    {
        return $this->belongsToMany(Caregiver::class, 'caregiver_contact');
    }
}
