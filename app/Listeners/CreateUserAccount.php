<?php

namespace App\Listeners;

use App\Events\UserProcessed;
use App\Services\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserAccount
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
    public function handle(UserProcessed $event)
    {
        $this->accountService->store($event->user);
    }
}
