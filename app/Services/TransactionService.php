<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\TransactionTypes;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    public function updateTotals(Transaction $transaction, User $user):void
    {
        $currentTotals = $this->getCurrentTotalsAccount($user);
        [$available, $total] = $this->calculateTotals(
            (float) $currentTotals['available'],
            (float) $currentTotals['total'],
            (float) $transaction->amount,
            $transaction->type
        );

        $this->updateTotalsAccount($currentTotals['id'], $available, $total);
    }

    private function getCurrentTotalsAccount(User $user): array
    {
        return Account::select('id', 'available', 'total')
            ->where('user_id', $user->id)
            ->firstOrFail()
            ->toArray();
    }

    private function calculateTotals(float $available, float $total, float $amount, string $type): array
    {
        if($type === TransactionTypes::ACCREDIT->value) {
            $available = $available + $amount;
            $total = $total + $amount;
        }

        if($type === TransactionTypes::DISCREDIT->value) {
            $available = $available - $amount;
            $total = $total - $amount;
        }
        
        return [$available, $total];
    }

    private function updateTotalsAccount(
        int $account,
        float $available,
        float $total
    ): void {
        Account::where('id', $account)->update([
            'available' => $available,
            'total' => $total
        ]);

        logger()->info('Account '.$account.' was updated with news totals: available -> '.$available.', total -> '.$total);
    }
}