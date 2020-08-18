<?php

namespace App\Policies\Blog;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->is_superuser;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $user->id === $project->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->id === $project->owner_id;
    }
}
