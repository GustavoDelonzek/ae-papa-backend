<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Http\Resources\DonationResource;
use App\Http\Services\DonationService;
use App\Models\Donation;

class DonationController extends Controller
{
    public function __construct(
        private readonly DonationService $donationService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DonationResource::collection($this->donationService->getAllDonations());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationRequest $request)
    {
        return DonationResource::make($this->donationService->storeDonation($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return DonationResource::make($donation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationRequest $request, Donation $donation)
    {
        return DonationResource::make($this->donationService->updateDonation($request->validated(), $donation));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return response()->json(['message' => 'Donation deleted successfully'], 200);
    }
}
