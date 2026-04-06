<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caregiver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'gender',
        'birth_date',
        'cpf',
        'rg',
        'education_level',
    ];

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'caregiver_patient')
            ->withPivot('kinship')
            ->withTimestamps()
            ->withTrashed();
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'caregiver_contact');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
