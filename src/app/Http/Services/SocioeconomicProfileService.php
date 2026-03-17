<?php

namespace App\Http\Services;

use App\Models\SocioeconomicProfile;

class SocioeconomicProfileService
{
    public function storeSocioeconomicProfile(array $data): SocioeconomicProfile
    {
        $data['income_source'] = json_encode($data['income_source']);
        $data['sanitation_details'] = json_encode($data['sanitation_details']);
        return SocioeconomicProfile::create($data);
    }

    public function updateSocioeconomicProfile(array $data, SocioeconomicProfile $socioeconomicProfile): SocioeconomicProfile
    {
        $socioeconomicProfile->income_source = json_encode($data['income_source']);
        $socioeconomicProfile->sanitation_details = json_encode($data['sanitation_details']);
        
        $socioeconomicProfile->update($data);

        return $socioeconomicProfile->fresh();
    }
}
