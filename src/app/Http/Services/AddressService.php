<?php

namespace App\Http\Services;

use App\Models\Address;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

readonly class AddressService
{
    public function getAllAdressesByPatient(array $data): Collection
    {
        return Address::where('patient_id', data_get($data, 'patient_id'))->get();
    }

    public function getAnAddressByPatient(array $data, Address $address): Address
    {
        if ($address->patient_id !== data_get($data, 'patient_id')) {
            abort(404);
        }

        return $address;
    }

    public function storeAddress(array $data): Address
    {
        return Address::create([
            'patient_id' => data_get($data, 'patient_id'),
            'street' => data_get($data, 'street'),
            'number' => data_get($data, 'number'),
            'neighborhood' => data_get($data, 'neighborhood'),
            'city' => data_get($data, 'city'),
            'cep' => data_get($data, 'cep'),
            'reference_point' => data_get($data, 'reference_point'),
        ]);
    }

    public function updateAddress(Address $address, array $data): Address
    {
        if (data_get($data, 'patient_id') !== $address->patient_id) {
            abort(404);
        }

        $address->update($data);

        return $address;
    }
}
