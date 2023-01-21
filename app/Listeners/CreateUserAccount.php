<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserProcessed;
use App\Services\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserAccount implements ShouldQueue
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
     * @param  \App\Events\UserProcessed  $event
     * @return void
     */
    public function handle(UserProcessed $event): void
    {
        $this->accountService->store($event->user);
    }
}
