<?php

namespace App\Policies\Blog;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Policies\Blog\ProjectMemberPolicyTrait;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;

class ProjectPolicy
{
    use HandlesAuthorization;
    use ProjectMemberPolicyTrait;

    /**
     * Policy filter called before policy method.
     */
    public function before(User $user, $ability)
    {
        $bypassed = ['createPost', 'createPostAudio'];

        if (!in_array($ability, $bypassed)) {
            if ($user->is_superuser) {
                return true;
            }
        }
    }

    /**
     *
     */
    public function replace(User $user, Project $project)
    {
        return $this->isProjectOwner($user, $project);
    }

    /**
     * Determine if user can create a project.
     *
     * @param  \App\Models\User\User  $user
     * @return boolean
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine if user can update the project.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return boolean
     */
    public function update(User $user, Project $project)
    {
        return $this->isProjectOwner($user, $project);
    }

    /**
     * Determine if user can delete the project.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return boolean
     */
    public function delete(User $user, Project $project)
    {
        return $this->isProjectOwner($user, $project);
    }

    /**
     * Determine if user can create a project post.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return boolean
     */
    public function createPost(User $user, Project $project)
    {
        return $this->isProjectOwner($user, $project) || $this->isMember($user, $project->id);
    }

    /**
     * Determine if user can create a project post audio.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return boolean
     */
    public function createPostAudio(User $user, Project $project)
    {
        return $this->isProjectOwner($user, $project) || $this->isMember($user, $project->id);
    }
}
