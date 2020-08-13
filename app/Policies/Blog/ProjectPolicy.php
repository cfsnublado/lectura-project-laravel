<?php

namespace App\Policies\Blog;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *
     */
    public function update(User $user, Project $task)
    {
        return $user->id === $project->owner_id;
    }
}
