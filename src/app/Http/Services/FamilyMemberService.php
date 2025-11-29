<?php

namespace App\Http\Services;

use App\Models\FamilyMember;
use App\Filters\FamilyMemberFilter;

class FamilyMemberService
{
    public function __construct(
    ) {
    }

    public function getFamilyMembers(array $filters = [])
    {
         $query = (new FamilyMemberFilter($filters, FamilyMember::query()))->applyFilters();

        return $query->paginate(data_get($filters, 'per_page', 15));
    }

    public function storeFamilyMember(array $data): FamilyMember
    {
        return FamilyMember::create($data);
    }

    public function updateFamilyMember(FamilyMember $familyMember, array $data): FamilyMember
    {
        $familyMember->update($data);

        return $familyMember;
    }

    public function deleteFamilyMember(FamilyMember $familyMember): void
    {
        $familyMember->delete();
    }
}
