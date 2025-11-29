<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'birth_date',
        'gender',
        'cpf',
        'rg',
        'marital_status',
        'mother_name',
        'father_name',
        'education_level',
        'sus_card_number',
    ];

    public function caregivers(): HasMany
    {
        return $this->hasMany(Caregiver::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function documents():HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_patient');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function socioeconomicProfile(): HasOne
    {
        return $this->hasOne(SocioeconomicProfile::class);
    }
}
