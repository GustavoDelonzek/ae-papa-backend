<?php

namespace App\Http\Services;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

readonly class AppointmentService
{

    public function getAllAppointmentsByPatient(array $data): Collection
    {
        return Appointment::where('patient_id', data_get($data, 'patient_id'))->get();
    }

    public function storeAppointment(array $data): Appointment
    {
        return Appointment::create([
            'patient_id' => data_get($data, 'patient_id'),
            'user_id' => data_get($data, 'user_id'),
            'date' => data_get($data, 'date'),
            'observations' => data_get($data, 'observations'),
            'objective' => data_get($data, 'objective'),
        ]);
    }

    public function getAnAppointmentByPatient(array $data, Appointment $appointment): Appointment
    {
        if ($appointment->patient_id !== data_get($data, 'patient_id')) {
            abort(404);
        }

        return $appointment;
    }

    public function updateAppointment(Appointment $appointment, array $data): Appointment
    {
        if (data_get($data, 'patient_id') !== $appointment->patient_id) {
            abort(404);
        }

        $appointment->update($data);

        return $appointment;
    }
}
