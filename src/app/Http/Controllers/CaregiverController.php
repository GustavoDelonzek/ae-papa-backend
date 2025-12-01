<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaregiverRequest;
use App\Http\Requests\UpdateCaregiverRequest;
use App\Http\Resources\CaregiverResource;
use App\Http\Services\CaregiverService;
use App\Models\Caregiver;

class CaregiverController extends Controller
{
    public function __construct(
        private readonly CaregiverService $caregiverService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->query('per_page', 15);
        $fullName = request()->query('full_name');
        
        return CaregiverResource::collection(
            $this->caregiverService->getAllCaregivers($perPage, $fullName)
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaregiverRequest $request)
    {
        return CaregiverResource::make($this->caregiverService->storeCaregiver($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Caregiver $caregiver)
    {
        return CaregiverResource::make($caregiver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCaregiverRequest $request, Caregiver $caregiver)
    {
        return CaregiverResource::make($this->caregiverService->updateCaregiver($caregiver, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caregiver $caregiver)
    {
        $caregiver->delete();

        return response()->json(['message' => 'Caregiver deleted successfully'], 200);
    }
}
