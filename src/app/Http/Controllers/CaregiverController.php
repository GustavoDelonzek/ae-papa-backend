<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientDependencyRequest;
use App\Http\Requests\StoreCaregiverRequest;
use App\Http\Requests\UpdateCaregiverRequest;
use App\Http\Resources\CaregiverResource;
use App\Http\Services\CaregiverService;
use App\Models\Caregiver;
use App\Models\Patient;
use Illuminate\Http\Request;

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
    public function index(PatientDependencyRequest $request)
    {
        return CaregiverResource::collection($this->caregiverService->getAllCaregiversByPatient($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaregiverRequest $request)
    {
        return new CaregiverResource($this->caregiverService->storeCaregiver($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientDependencyRequest $request, Caregiver $caregiver)
    {
        return new CaregiverResource($this->caregiverService->getAnCaregiverByPatient($request->validated(), $caregiver));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCaregiverRequest $request, Caregiver $caregiver)
    {
        return new CaregiverResource($this->caregiverService->updateCaregiver($caregiver, $request->validated()));
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
