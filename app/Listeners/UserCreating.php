<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use App\Events\UserCreating as UserCreatingEvent;

class UserCreating
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
     * @param  \App\Events\UserCreatingEvent $event
     * @return mixed
     */
    public function handle(UserCreatingEvent $event)
    {
        $user = $event->user;
        if (!$user->{$user->getKeyName()}) {
            $user->{$user->getKeyName()} = (string) Str::uuid();
        }
    }
}
