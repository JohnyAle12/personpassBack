<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\AccountStates;
use App\Models\Account;
use App\Models\User;

class AccountService
{
    public function store(User $user): void
    {
        Account::create([
            'user_id' => $user->id,
            'available' => 0.00,
            'total' => 0.00,
            'state' => AccountStates::AVAILABLE->value,
        ]);
    }
}