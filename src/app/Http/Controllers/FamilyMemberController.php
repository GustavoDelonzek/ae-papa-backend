<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyMemberFilterRequest;
use App\Http\Requests\StoreFamilyMemberRequest;
use App\Http\Requests\UpdateFamilyMemberRequest;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Services\FamilyMemberService;
use Illuminate\Http\Request;
use App\Models\FamilyMember;

class FamilyMemberController extends Controller
{
    public function __construct(
        private FamilyMemberService $familyService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FamilyMemberFilterRequest $request)
    {
        return FamilyMemberResource::make($this->familyService->getFamilyMembers($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyMemberRequest $request)
    {
        return FamilyMemberResource::make($this->familyService->storeFamilyMember($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyMember $familyMember)
    {
        return FamilyMemberResource::make($familyMember);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyMemberRequest $request, FamilyMember $familyMember)
    {
        return FamilyMemberResource::make($this->familyService->updateFamilyMember($familyMember, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyMember $familyMember)
    {
        $this->familyService->deleteFamilyMember($familyMember);
    }
}
