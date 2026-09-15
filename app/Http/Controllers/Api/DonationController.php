<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchDonationRequest;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Donation;
use App\Services\DonationService;

class DonationController extends Controller
{
    public function __construct(
        private readonly DonationService $donationService
    ) {}

    public function index(SearchDonationRequest $request)
    {
        $paymentMethod = $request->input('payment_method');
        $donationDate = $request->input('donation_date');

        $donations = $this->donationService->getDonations($paymentMethod, $donationDate);

        return DonationResource::collection($donations);
    }

    public function store(StoreDonationRequest $request)
    {
        $donation = $this->donationService->createDonation($request->validated());
        return DonationResource::make($donation)
            ->response()
            ->setStatusCode(201);
    }

    public function update(Donation $donation, UpdateDonationRequest $request)
    {
        $donation->update($request->validated());
        return DonationResource::make($donation);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return response()->json("La donación fue eliminada", 200);
    }
}
