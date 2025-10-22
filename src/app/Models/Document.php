<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'file_name',
        'file_path',
        'document_type',
        'mime_type',
        'description',
        'appointment_id',
        'status',
    ];

    protected $appends = [
        'public_url',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function publicUrl(): Attribute
    {
        if (empty($this->file_path)) {
            return Attribute::make(get: fn () => null);
        }

        return Attribute::make(
            get: fn () => Storage::disk('gcs')->temporaryUrl(
                $this->file_path,
                now()->addMinutes(15)
            ),
        );
    }
}
