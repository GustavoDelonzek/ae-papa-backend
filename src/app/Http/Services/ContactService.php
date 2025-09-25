<?php

namespace App\Http\Services;

use App\Filters\ContactFilter;
use App\Models\Caregiver;
use App\Models\Contact;
use App\Models\Patient;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactService
{
    public function showAllContacts(array $filters, Builder $query): LengthAwarePaginator
    {
        $contactsBuilder = (new ContactFilter($filters, $query))->applyFilters();
        return $contactsBuilder->paginate(data_get($filters, 'per_page', 15));
    }

    public function getAllByPatient(array $filters, Patient $patient): LengthAwarePaginator
    {
        return $this->showAllContacts($filters, $patient->contacts()->getQuery());
    }

    public function getAllByCaregiver(array $filters, Caregiver $caregiver): LengthAwarePaginator
    {
        return $this->showAllContacts($filters, $caregiver->contacts()->getQuery());
    }

    public function storeContact(array $data): Contact
    {
        $contact = Contact::create($data);

        if (data_get($data, 'patient_id')) {
            $contact->patient()->attach($data['patient_id'], ['patient_id' => $data['patient_id']]);
        }

        if (data_get($data, 'caregiver_id')) {
            $contact->caregiver()->attach($data['caregiver_id'], ['caregiver_id' => $data['caregiver_id']]);
        }

        return $contact;
    }

    public function updateContact(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function deleteContact(Contact $contact): void
    {
        $contact->patient()->detach();
        $contact->caregiver()->detach();
        $contact->delete();
    }
}
