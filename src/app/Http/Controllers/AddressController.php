<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientAddressRequest;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Services\AddressService;
use App\Models\Address;

class AddressController extends Controller
{
    public function __construct(
        private readonly AddressService $addressService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PatientAddressRequest $request)
    {
        return AddressResource::collection($this->addressService->getAllAdressesByPatient($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        return new AddressResource($this->addressService->storeAddress($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientAddressRequest $request, Address $address)
    {
        return new AddressResource($this->addressService->getAnAddressByPatient($request->validated(), $address));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        return new AddressResource($this->addressService->updateAddress($address, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
