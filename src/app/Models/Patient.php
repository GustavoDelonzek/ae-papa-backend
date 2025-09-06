<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    const GENDERS = ['M', 'F'];

    protected $fillable = [
        'full_name',
        'birth_date',
        'gender',
        'cpf',
        'rg',
        'marital_status',
    ];

    public function caregivers()
    {
        return $this->hasMany(Caregiver::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'owner');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
