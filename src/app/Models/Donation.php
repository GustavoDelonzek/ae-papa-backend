<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'appointment_id',
        'type',
        'details',
        'quantity',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
