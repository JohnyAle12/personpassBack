<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PocketProcessed;
use App\Services\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAvailableAccount implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private AccountService $accountService
    ) {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PocketProcessed  $event
     * @return void
     */
    public function handle(PocketProcessed $event)
    {
        $this->accountService->updateAvailableAmount(
            $event->pocket,
            $event->account,
            $event->deleted
        );
    }
}
