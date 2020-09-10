<?php

namespace App\Policies\Blog;

use Illuminate\Support\Str;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;

trait ProjectMemberPolicyTrait
{
    /**
     * Determine if user is the project owner.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Blog\Project  $project
     * @return boolean
     */
    protected function isProjectOwner(User $user, Project $project)
    {
        return $user->id === $project->owner_id;
    }

    /**
     * Determine if user is a member of a project team.
     *
     * @param  \App\Models\User\User  $user
     * @param  int $projectId
     * @return boolean
     */
    public function isMember(User $user, $projectId)
    {
        $isMember = ProjectMember::where([
            ['project_id', $projectId],
            ['member_id', $user->id]
        ])->exists();

        return $isMember;
    }

    /**
     * Determine if user is a given role in project team.
     *
     * @param  \App\Models\User\User  $user
     * @param  int $projectId
     * @param  int $roleId (Key in ProjectMember::ROLES)
     * @return boolean
     */
    public function isRole(User $user, $projectId, $roleId)
    {
        $isRole = false;

        if (array_key_exists($roleId, ProjectMember::ROLES)) {
            $isRole = ProjectMember::where([
                ['project_id', $projectId],
                ['member_id', $user->id],
                ['role', $roleId],
            ])->exists();
        }

        return $isRole;
    }

    /**
     * Determine if user is a given role or above in project team.
     *
     * @param  \App\Models\User\User  $user
     * @param  int $projectId
     * @param  int $roleId (Key in ProjectMember::ROLES)
     * @return boolean
     */
    public function isRoleOrAbove(User $user, $projectId, $roleId)
    {
        $isRoleOrAbove = false;

        if (array_key_exists($roleId, ProjectMember::ROLES)) {
            $isRoleOrAbove = ProjectMember::where([
                ['project_id', $projectId],
                ['member_id', $user->id],
                ['role', '>=', $roleId],
            ])->exists();
        }

        return $isRoleOrAbove;
    }
}