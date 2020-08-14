<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectTeam;

class ProjectTeamTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        $this->project = Project::create([
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
        ]);
    }

    /**
     * Test key and value pairs of roles.
     *
     * @return void
     */
    public function testRolesKeysAndValues()
    {
        $roles = [
            1 => 'author',
            2 => 'editor',
            3 => 'admin',
        ];
        $this->assertEquals($roles, ProjectTeam::ROLES);
    }

    /**
     * Test default role.
     *
     * @return void
     */
    public function testDefaultRole()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        $team = ProjectTeam::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
        ]);
        $team->refresh();
        $this->assertEquals($team->role_id, 1);
        $this->assertEquals($team->role, 'author');
    }

    /**
     * Test unique together member, project.
     *
     * @return void
     */
    public function testUniqueTogetherMemberProject()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        ProjectTeam::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
        ]);
        
        $this->expectException('Illuminate\Database\QueryException');
        $this->expectExceptionMessage('Integrity constraint violation');

        ProjectTeam::create([
            'member_id' => $user->id,
            'project_id' => $this->project->id,
            'role' => 2
        ]);
    }
}
