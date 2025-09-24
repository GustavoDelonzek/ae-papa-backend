<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Services\ContactService;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService
    ) {}

    public function index(Request $request)
    {
        return response()->json([
            'contacts' => ContactResource::collection(
                $this->contactService->showAllContacts($request->all())
            )
        ], 200);
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
