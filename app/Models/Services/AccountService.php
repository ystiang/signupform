<?php

namespace App\Models\Services;

use App\Models\Account;

class AccountService
{
    public function createAccount($firstName, $lastName, $email, $password, $country, $phone, $referralID)
    {
        Account::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'country' => $country,
            'phone' => $phone,
            'referral_id' => $referralID,
        ]);
    }
}