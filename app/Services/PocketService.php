<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\PocketProcessed;
use App\Models\Account;
use App\Models\Pocket;
use Illuminate\Http\Request;

class PocketService
{
    public function createPocket(Request $request, Account $account): Pocket
    {
        $pocket = Pocket::create([
            'user_id' => $request->user()->id,
            'account_id' => $account->id,
            'name' => $request->name,
            'amount' => $request->amount,
            'description' => $request->description
        ]);

        event(new PocketProcessed(
            $pocket,
            $account
        ));

        return $pocket;
    }
}