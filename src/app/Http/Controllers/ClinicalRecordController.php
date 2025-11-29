<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClinicalRecordFilterRequest;
use App\Http\Requests\StoreClinicalRecordRequest;
use App\Http\Requests\UpdateClinicalRecordRequest;
use App\Http\Resources\ClinicalRecordResource;
use App\Models\ClinicalRecord;
use App\Http\Services\ClinicalRecordService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClinicalRecordController extends Controller
{
    public function __construct(
        private ClinicalRecordService $clinicalRecordService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(ClinicalRecordFilterRequest $request): AnonymousResourceCollection
    {
        return ClinicalRecordResource::collection(
            $this->clinicalRecordService->index($request->validated())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClinicalRecordRequest $request): ClinicalRecordResource
    {
        return ClinicalRecordResource::make(
            $this->clinicalRecordService->storeClinicalRecord($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(ClinicalRecord $clinicalRecord): ClinicalRecordResource
    {
        return ClinicalRecordResource::make($clinicalRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClinicalRecordRequest $request, ClinicalRecord $clinicalRecord)
    {
        return ClinicalRecordResource::make(
            $this->clinicalRecordService->updateClinicalRecord($clinicalRecord, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClinicalRecord $clinicalRecord): void
    {
        $this->clinicalRecordService->deleteClinicalRecord($clinicalRecord);
    }
}
