<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;
use App\Policies\Blog\ProjectPolicy;

class ProjectMemberPolicyTraitTest extends TestCase
{
    use DatabaseTransactions;

    private $owner;
    private $admin;
    private $adminRole;
    private $editor;
    private $editorRole;
    private $author;
    private $authorRole;
    private $nonMember;
    private $project;
    private $policy;

    public function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->nonMember = factory(User::class)->create();
        $this->owner = factory(User::class)->create();
        $this->project = factory(Project::class) ->create([
            'owner_id' => $this->owner->id
        ]);

        $this->admin = factory(User::class)->create();
        $this->adminRole = ProjectMember::create([
            'member_id' => $this->admin->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_ADMIN
        ]);

        $this->editor = factory(User::class)->create();
        $this->editorRole = ProjectMember::create([
            'member_id' => $this->editor->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_EDITOR
        ]);

        $this->author = factory(User::class)->create();
        $this->authorRole = ProjectMember::create([
            'member_id' => $this->author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);

        $this->policy = new ProjectPolicy();
    }

    public function testIsMember() {
        $this->assertTrue(
            $this->policy->isMember($this->author, $this->project->id)
        );
        $this->assertTrue(
            $this->policy->isMember($this->editor, $this->project->id)
        );
        $this->assertTrue(
            $this->policy->isMember($this->author, $this->project->id)
        );
        $this->assertFalse(
            $this->policy->isMember($this->nonMember, $this->project->id)
        );
    }

    public function testIsRole() {
        // Author
        $this->assertFalse(
            $this->policy->isRole(
                $this->nonMember, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );
        $this->assertTrue(
            $this->policy->isRole(
                $this->author, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );
        $this->assertFalse(
            $this->policy->isRole(
                $this->editor, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );
        $this->assertFalse(
            $this->policy->isRole(
                $this->admin, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );

        // Editor
        $this->assertFalse(
            $this->policy->isRole(
                $this->nonMember, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );
        $this->assertFalse(
            $this->policy->isRole(
                $this->author, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );
        $this->assertTrue(
            $this->policy->isRole(
                $this->editor, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );
        $this->assertFalse(
            $this->policy->isRole(
                $this->admin, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );

        // Admin
        $this->assertFalse(
            $this->policy->isRole(
                $this->nonMember, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
        $this->assertFalse(
            $this->policy->isRole(
                $this->author, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
        $this->assertFalse(
            $this->policy->isRole(
                $this->editor, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
        $this->assertTrue(
            $this->policy->isRole(
                $this->admin, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
    }

    public function testIsRoleOrAbove() {
        // Author
        $this->assertFalse(
            $this->policy->isRoleOrAbove(
                $this->nonMember, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );
        $this->assertTrue(
            $this->policy->isRoleOrAbove(
                $this->author, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );
        $this->assertTrue(
            $this->policy->isRoleOrAbove(
                $this->editor, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );
        $this->assertTrue(
            $this->policy->isRoleOrAbove(
                $this->admin, $this->project->id, ProjectMember::ROLE_AUTHOR
            )
        );

        // Editor
        $this->assertFalse(
            $this->policy->isRoleOrAbove(
                $this->nonMember, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );
        $this->assertFalse(
            $this->policy->isRoleOrAbove(
                $this->author, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );
        $this->assertTrue(
            $this->policy->isRoleOrAbove(
                $this->editor, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );
        $this->assertTrue(
            $this->policy->isRoleOrAbove(
                $this->admin, $this->project->id, ProjectMember::ROLE_EDITOR
            )
        );

        // Admin
        $this->assertFalse(
            $this->policy->isRoleOrAbove(
                $this->nonMember, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
        $this->assertFalse(
            $this->policy->isRoleOrAbove(
                $this->author, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
        $this->assertFalse(
            $this->policy->isRoleOrAbove(
                $this->editor, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );
        $this->assertTrue(
            $this->policy->isRoleOrAbove(
                $this->admin, $this->project->id, ProjectMember::ROLE_ADMIN
            )
        );

    }
}
