<?php

namespace App\Http\Services;

use App\Models\SocioeconomicProfile;

class SocioeconomicProfileService
{
    public function storeSocioeconomicProfile(array $data): SocioeconomicProfile
    {
        return SocioeconomicProfile::create($data);
    }

    public function updateSocioeconomicProfile(array $data, SocioeconomicProfile $socioeconomicProfile): SocioeconomicProfile
    {
        $socioeconomicProfile->update($data);

        return $socioeconomicProfile->fresh();
    }
}
