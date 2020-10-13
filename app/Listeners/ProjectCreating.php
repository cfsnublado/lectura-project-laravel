<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use App\Events\ProjectCreating as ProjectCreatingEvent;

class ProjectCreating
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
     * @param  \App\Events\ProjectCreatingEvent $event
     * @return mixed
     */
    public function handle(ProjectCreatingEvent $event)
    {
        $project = $event->project;

        if (!$project->uuid) {
            $project->uuid = (string) Str::uuid();
        }
    }
}
