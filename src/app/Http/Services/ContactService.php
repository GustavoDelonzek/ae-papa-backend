<?php

namespace App\Http\Services;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    /**
     * Listar todos os contatos com possibilidade de filtros
     */
    public function showAllContacts(array $filters = []): Collection|LengthAwarePaginator
    {
        $query = Contact::query();

        if (!empty($filters['owner_id'])) {
            $query->where('owner_id', $filters['owner_id']);
        }
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (!empty($filters['paginate']) && $filters['paginate'] === true) {
            $perPage = $filters['per_page'] ?? 15;
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * Cria um novo contato
     */
    public function storeContact(array $data): Contact
    {
        return Contact::create($data);
    }

    /**
     * Atualiza um contato existente
     */
    public function updateContact(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    /**
     * Exclui um contato
     */
    public function deleteContact(Contact $contact): void
    {
        $contact->delete();
    }
}

