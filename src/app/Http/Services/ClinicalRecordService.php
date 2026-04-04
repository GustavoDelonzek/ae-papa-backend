<?php

namespace App\Http\Services;

use App\Filters\ClinicalRecordFilter;
use App\Http\Requests\StoreClinicalRecordRequest;
use App\Models\ClinicalRecord;
use Illuminate\Pagination\LengthAwarePaginator;

class ClinicalRecordService
{
    public function __construct(

    ) {
    }

    public function index(array $filters): LengthAwarePaginator
    {
        $builder = (new ClinicalRecordFilter($filters, ClinicalRecord::query()))->applyFilters();
        $builder->orderBy('created_at', 'desc');

        return $builder->paginate(data_get($builder, 'perPage'));
    }

    public function storeClinicalRecord(array $data): ClinicalRecord
    {
        if (isset($data['diagnosis_date'])) {
            $data['diagnosis_date'] = \Carbon\Carbon::createFromFormat('m-d-Y', $data['diagnosis_date'])->format('Y-m-d');
        }
        return ClinicalRecord::create($data);
    }

    public function updateClinicalRecord(ClinicalRecord $record, array $data): ClinicalRecord
    {
        if (isset($data['diagnosis_date'])) {
            $data['diagnosis_date'] = \Carbon\Carbon::createFromFormat('m-d-Y', $data['diagnosis_date'])->format('Y-m-d');
        }
        $record->update($data);

        return $record->fresh();
    }

    public function deleteClinicalRecord(ClinicalRecord $record): void
    {
        $record->delete();
    }
}
