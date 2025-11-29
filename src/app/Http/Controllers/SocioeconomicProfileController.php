<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocioeconomicProfileRequest;
use App\Http\Requests\UpdateSocioeconomicRequest;
use App\Http\Resources\SocioeconomicProfileResource;
use App\Http\Services\SocioeconomicProfileService;
use App\Models\SocioeconomicProfile;

class SocioeconomicProfileController extends Controller
{
    public function __construct(
        private readonly SocioeconomicProfileService $service
    ) {
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocioeconomicProfileRequest $request): SocioeconomicProfileResource
    {
        return SocioeconomicProfileResource::make($this->service->storeSocioeconomicProfile($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(SocioeconomicProfile $socioeconomicProfile): SocioeconomicProfileResource
    {
        return SocioeconomicProfileResource::make($socioeconomicProfile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocioeconomicRequest $request, SocioeconomicProfile $socioeconomicProfile): SocioeconomicProfileResource
    {
        return SocioeconomicProfileResource::make($this->service->updateSocioeconomicProfile($request->validated(), $socioeconomicProfile));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocioeconomicProfile $socioeconomicProfile): void
    {
        $socioeconomicProfile->delete();
    }
}
