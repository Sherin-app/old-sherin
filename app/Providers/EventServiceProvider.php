<?php

namespace App\Providers;

use App\Events\OrderEvent;
use App\Listeners\OrderListener;
use App\Events\OwnerEvent;
use App\Listeners\OwnerListener;
use App\Events\EmployEvent;
use App\Listeners\EmployListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OwnerEvent::class => [
            OwnerListener::class,
        ],
        EmployEvent::class => [
            EmployListener::class,
        ],
        OrderEvent::class=>[
            OrderListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
