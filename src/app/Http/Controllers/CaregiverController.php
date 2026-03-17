<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachPatientRequest;
use App\Http\Requests\StoreCaregiverRequest;
use App\Http\Requests\UpdateCaregiverRequest;
use App\Http\Resources\CaregiverResource;
use App\Http\Services\CaregiverService;
use App\Models\Caregiver;
use App\Models\Patient;

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
        return CaregiverResource::collection($this->caregiverService->getAllCaregivers());
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
        return CaregiverResource::make($caregiver->load(['patients', 'contacts']));
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

    public function attachPatient(AttachPatientRequest $request, Caregiver $caregiver, Patient $patient)
    {
        $caregiver = $this->caregiverService->attachPatient(
            $caregiver,
            $patient,
            $request->validated('kinship')
        );

        return CaregiverResource::make($caregiver)
            ->additional(['message' => 'Caregiver successfully linked to patient']);
    }

    public function detachPatient(Caregiver $caregiver, Patient $patient)
    {
        $this->caregiverService->detachPatient($caregiver, $patient);

        return response()->json(['message' => 'Caregiver successfully unlinked from patient'], 200);
    }

    public function updatePatientRelationship(AttachPatientRequest $request, Caregiver $caregiver, Patient $patient)
    {
        $caregiver = $this->caregiverService->updatePatientRelationship(
            $caregiver,
            $patient,
            $request->validated('kinship')
        );

        return CaregiverResource::make($caregiver)
            ->additional(['message' => 'Relationship updated successfully']);
    }
}
