<?php

namespace App\Policies\Blog;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\Blog\ProjectMemberPolictyTrait;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;
use App\Models\Blog\Post;

class PostPolicy
{
    use HandlesAuthorization;
    use ProjectMemberPolicyTrait;

    /**
     * Determine if user is the post creator.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Post  $post
     * @return boolean
     */
    protected function isCreator(User $user, Post $post)
    {
        return $user->id === $post->creator_id;
    }

    public function before(User $user, $ability)
    {
        if ($user->is_superuser) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User\User $user
     * @param  \App\Models\Blog\Post $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        $role = ProjectMember::ROLE_EDITOR;
        return $this->isCreator($user, $post)
            || $this->isRoleOrAbove($user, $post->project_id, $role);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User\User $user
     * @param \App\Models\Blog\Post $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        $role = ProjectMember::ROLE_EDITOR;
        return $this->isCreator($user, $post)
            || $this->isRoleOrAbove($user, $post->project_id, $role);
    }
}
