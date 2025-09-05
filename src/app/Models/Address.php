<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'patient_id',
        'street',
        'number',
        'neighborhood',
        'city',
        'cep',
        'reference_point',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
