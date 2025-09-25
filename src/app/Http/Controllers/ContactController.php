<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFilterRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Services\ContactService;
use App\Models\Caregiver;
use App\Models\Contact;
use App\Models\Patient;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService
    ) {
    }

    public function getAllByPatient(ContactFilterRequest $request, Patient $patient){
        return ContactResource::collection(
            $this->contactService->getAllByPatient($request->validated(), $patient)
        );
    }

    public function getAllByCaregiver(ContactFilterRequest $request, Caregiver $caregiver){
        return ContactResource::collection(
            $this->contactService->getAllByCaregiver($request->validated(), $caregiver)
        );
    }

    public function store(StoreContactRequest $request)
    {
        return ContactResource::make(
            $this->contactService->storeContact($request->validated())
        );
    }

    public function show(Contact $contact)
    {
        return ContactResource::make($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        return ContactResource::make(
            $this->contactService->updateContact($contact, $request->validated())
        );
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return response()->json(['message' => 'Contact deleted successfully'], 200);
    }
}
