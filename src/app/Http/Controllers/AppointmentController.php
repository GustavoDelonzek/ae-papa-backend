<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $appointmentService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return AppointmentResource::collection($this->appointmentService->getAllAppointment());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request): AppointmentResource
    {
        return AppointmentResource::make($this->appointmentService->storeAppointment($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): AppointmentResource
    {
        return AppointmentResource::make($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        return AppointmentResource::make($this->appointmentService->updateAppointment($appointment, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment) //TODO: APLICAR SOFTDELETE NESSA MODEL
    {
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully'], 200);
    }
}
