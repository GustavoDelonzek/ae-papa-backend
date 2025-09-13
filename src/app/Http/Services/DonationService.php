<?php

namespace App\Http\Services;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Collection;

readonly class DonationService
{
    public function getAllDonations(): Collection
    {
        return Donation::query()->get();
    }

    public function storeDonation(array $data): Donation
    {
        return Donation::create($data);
    }

    public function showDonationById(Donation $donation): Donation
    {
        return $donation;
    }

    public function updateDonation(array $data, Donation $donation): Donation
    {
        if ($donation->appointment_id !== data_get($data, 'appointment_id')) {
            abort(404);
        }
        
        $donation->update($data);

        return $donation;
    }

    public function deleteDonation(Donation $donation): bool
    {
        return $donation->delete();
    }
}
