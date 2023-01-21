<?php

namespace App\Providers;

use App\Events\PocketProcessed;
use App\Events\TransactionProcessed;
use App\Events\UserProcessed;
use App\Listeners\CreateUserAccount;
use App\Listeners\UpdateAccountTotals;
use App\Listeners\UpdateAvailableAccount;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            UserProcessed::class,
            [CreateUserAccount::class, 'handle']
        );

        Event::listen(
            TransactionProcessed::class,
            [UpdateAccountTotals::class, 'handle']
        );

        Event::listen(
            PocketProcessed::class,
            [UpdateAvailableAccount::class, 'handle']
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
