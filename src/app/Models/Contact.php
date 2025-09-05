<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'owner_id',
        'owner_type',
        'type',
        'value',
        'is_primary',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
