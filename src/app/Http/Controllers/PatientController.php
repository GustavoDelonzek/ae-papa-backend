<?php

namespace App\Http\Controllers;

use App\Filters\PatientFilter;
use App\Http\Requests\PatientFilterRequest;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Services\PatientService;
use App\Models\Patient;
use Dotenv\Store\File\Paths;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PatientFilterRequest $request)
    {
        return response()->json([
            'patients' => PatientResource::collection(
                $this->patientService->showAllPatients($request->validated())
            )
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        return new PatientResource($this->patientService->storePatient($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        return new PatientResource($this->patientService->updatePatient($patient, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->patientService->deletePatient($patient);

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }
}
