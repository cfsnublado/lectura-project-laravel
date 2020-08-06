<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UserCreated as UserCreatedEvent;
use App\Profile;

class UserCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreatedEvent $event
     * @return mixed
     */
    public function handle(UserCreatedEvent $event)
    {
        if (!$event->user->profile) {
            $event->user->profile()->create();
        }
    }
}
