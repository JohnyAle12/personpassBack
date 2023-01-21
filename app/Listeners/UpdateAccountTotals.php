<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TransactionProcessed;
use App\Services\TransactionService;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAccountTotals implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private TransactionService $transactionService
    ) {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionProcessed  $event
     * @return void
     */
    public function handle(TransactionProcessed $event)
    {
        $this->transactionService->updateTotals(
            $event->transaction,
            $event->user
        );
    }
}
