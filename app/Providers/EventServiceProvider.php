<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UserCreated as UserCreatedEvent;
use App\Events\UserCreating as UserCreatingEvent;
use App\Events\ProjectCreating as ProjectCreatingEvent;
use App\Listeners\UserCreated as UserCreatedListener;
use App\Listeners\UserCreating as UserCreatingListener;
use App\Listeners\ProjectCreating as ProjectCreatingListener;

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
        UserCreatedEvent::class => [
            UserCreatedListener::class,
        ],
        UserCreatingEvent::class => [
            UserCreatingListener::class,
        ],
        ProjectCreatingEvent::class => [
            ProjectCreatingListener::class,
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
