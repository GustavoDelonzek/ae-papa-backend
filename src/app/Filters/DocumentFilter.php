<?php

namespace App\Filters;

class DocumentFilter extends AbstractQueryFilters
{
    public function patientId($patientId): void
    {
        $this->query->where('patient_id', $patientId);
    }

    public function documentType($documentType): void
    {
        $this->query->where('document_type', $documentType);
    }

    public function status($status): void
    {
        $this->query->where('status', $status);
    }

    public function name($name): void
    {
        $this->query->where('file_name', 'ilike', '%' . $name . '%');
    }
}
