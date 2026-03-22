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
use Illuminate\Support\Facades\Storage;

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
        return PatientResource::collection(
            $this->patientService->showAllPatients($request->validated()
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        return PatientResource::make($this->patientService->storePatient($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return PatientResource::make($patient->load('caregivers', 'socioeconomicProfile', 'clinicalRecord', 'addresses', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        return PatientResource::make($this->patientService->updatePatient($patient, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->patientService->deletePatient($patient);

        return response()->json(['message' => 'Patient deleted successfully'], 204);
    }

    public function uploadProfilePicture(Request $request, Patient $patient)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB
        ]);

        $patient = $this->patientService->uploadProfilePicture($patient, $request->file('image'));

        return PatientResource::make($patient);
    }

    public function getProfilePicture(Patient $patient)
    {
        if (!$patient->profile_picture_path || !Storage::disk('gcs')->exists($patient->profile_picture_path)) {
            abort(404, 'Profile picture not found.');
        }

        return Storage::disk('gcs')->response($patient->profile_picture_path);
    }
}
