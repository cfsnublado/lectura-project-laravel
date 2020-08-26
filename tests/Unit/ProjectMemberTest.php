<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;

class ProjectMemberTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);
    }

    /**
     * Test key and value pairs of roles.
     *
     * @return void
     */
    public function testRolesKeysAndValues()
    {
        $this->assertEquals(ProjectMember::ROLE_AUTHOR, 1);
        $this->assertEquals(ProjectMember::ROLE_EDITOR, 2);
        $this->assertEquals(ProjectMember::ROLE_ADMIN, 3);

        $roles = [
            ProjectMember::ROLE_AUTHOR => 'author',
            ProjectMember::ROLE_EDITOR => 'editor',
            ProjectMember::ROLE_ADMIN => 'admin',
        ];
        $this->assertEquals($roles, ProjectMember::ROLES);
    }

    /**
     * Test default role.
     *
     * @return void
     */
    public function testDefaultRole()
    {
        $user = factory(User::class)->create();
        $member = ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
        ]);
        $member->refresh();
        $this->assertEquals($member->role, 1);
        $this->assertEquals($member->role_value, 'author');
    }

    /**
     * Test role values.
     *
     * @return void
     */
    public function testRoleValues()
    {
        $author = factory(User::class)->create();
        $authorRole = ProjectMember::create([
            'member_id' => $author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR,
        ]);
        $this->assertEquals($authorRole->role_value, 'author');

        $editor = factory(User::class)->create();
        $editorRole = ProjectMember::create([
            'member_id' => $editor->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_EDITOR,
        ]);
        $this->assertEquals($editorRole->role_value, 'editor');

        $admin = factory(User::class)->create();
        $adminRole = ProjectMember::create([
            'member_id' => $admin->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_ADMIN,
        ]);
        $this->assertEquals($adminRole->role_value, 'admin');
    }

    /**
     * Test setting role out of range of ProjectMember::ROLES.
     *
     * @return void
     */
    public function testSetRoleOutOfRange()
    {
        $user = factory(User::class)->create();
        $member = ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR,
        ]);
        $this->assertEquals($member->role, ProjectMember::ROLE_AUTHOR);
        $member->role = ProjectMember::ROLE_EDITOR;
        $member->save();
        $this->assertEquals($member->role, ProjectMember::ROLE_EDITOR);
        // Role not changed if set out of range of ProjectMember::ROLES.
        $member->role = 100;
        $member->save();
        $this->assertEquals($member->role, ProjectMember::ROLE_EDITOR);
    }

    /**
     * Test unique together member, project.
     *
     * @return void
     */
    public function testUniqueTogetherMemberProject()
    {
        $user = factory(User::class)->create();
        ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
        ]);
        
        $this->expectException('Illuminate\Database\QueryException');
        $this->expectExceptionMessage('Integrity constraint violation');

        ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
            'role' => 2
        ]);
    }
}
