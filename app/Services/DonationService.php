<?php

namespace App\Services;

use App\Models\Donation;

class DonationService
{
    public function getDonations(?string $paymentMethod = null, ?string $date = null)
    {
        $query = Donation::query();

        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        if ($date) {
            $query->where('donation_date', $date);
        }

        return $query->get();   
    }
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