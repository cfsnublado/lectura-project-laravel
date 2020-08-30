<?php

namespace App\Policies\Blog;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\Blog\ProjectMemberPolictyTrait;
use App\Models\User\User;
use App\Models\Blog\ProjectMember;
use App\Models\Blog\PostAudio;

class PostAudioPolicy
{
    use HandlesAuthorization;
    use ProjectMemberPolicyTrait;

    /**
     * Determine if user is the post creator.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\PostAudio  $postAudio
     * @return boolean
     */
    protected function isCreator(User $user, PostAudio $postAudio)
    {
        return $user->id === $postAudio->creator_id;
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
     * @param  \App\Models\Blog\PostAudio $postAudio
     * @return mixed
     */
    public function update(User $user, PostAudio $postAudio)
    {
        $role = ProjectMember::ROLE_EDITOR;
        return $this->isCreator($user, $postAudio)
            || $this->isRoleOrAbove($user, $postAudio->post->project_id, $role);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User\User $user
     * @param \App\Models\Blog\PostAudio $postAudio
     * @return mixed
     */
    public function delete(User $user, PostAudio $postAudio)
    {
        $role = ProjectMember::ROLE_EDITOR;
        return $this->isCreator($user, $postAudio)
            || $this->isRoleOrAbove($user, $postAudio->post->project_id, $role);
    }
}
