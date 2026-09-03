<?php

namespace App\Services;

use App\Models\Donation;

class DonationService
{
    public function createDonation(array $data): Donation
    {
        $data['donation_date'] = now();
        return Donation::create($data);
    }

    public function updateDonation(Donation $donation, array $data)
    {
        $donation->update($data);
        return $donation;
    }

}