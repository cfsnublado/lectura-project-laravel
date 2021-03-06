<?php

namespace Tests\Unit\Models;

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
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create([
            'owner_id' => $this->user->id,
        ]);
    }

    /**
     *
     */
    public function testEagerLoad()
    {
        $user = User::factory()->create();
        ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
        ]);
        $member = ProjectMember::where(
            [['member_id', $user->id], ['project_id', $this->project->id]]
        )->firstOrFail();
    
        $this->assertTrue($member->relationLoaded('member'));
        $this->assertTrue($member->relationLoaded('project'));
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
        $user = User::factory()->create();
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
        $author = User::factory()->create();
        $authorRole = ProjectMember::create([
            'member_id' => $author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR,
        ]);
        $this->assertEquals($authorRole->role_value, 'author');

        $editor = User::factory()->create();
        $editorRole = ProjectMember::create([
            'member_id' => $editor->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_EDITOR,
        ]);
        $this->assertEquals($editorRole->role_value, 'editor');

        $admin = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
        ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
        ]);
        
        $this->expectException('Illuminate\Database\QueryException');
        $this->expectExceptionMessage('Unique violation');

        ProjectMember::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
            'role' => 2
        ]);
    }
}
