<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectPolicyTest extends TestCase
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
            'description' => 'This is a test project.'
        ]);
    }

    /**
     * Test if superuser, non-owner can update project.
     *
     * @return void
     */
    public function testSuperuserNonOwnerCanUpdate()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'foo?69f',
            'is_superuser' => true
        ]);
        $this->assertTrue($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertTrue($user->can('update', $this->project));
    }

    /**
     * Test if owner, non-superuser can update project.
     *
     * @return void
     */
    public function testOwnerCanUpdate()
    {
        $this->assertFalse($this->user->is_superuser);
        $this->assertEquals($this->user->id, $this->project->owner_id);
        $this->assertTrue($this->user->can('update', $this->project));
    }

    /**
     * Test if non-superuser, non-owner can't update project.
     *
     * @return void
     */
    public function testNonSuperuserNonOwnerCanNotUpdate()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'foo?69f',
        ]);
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertFalse($user->can('update', $this->project));
    }

    /**
     * Test if superuser, non-owner can delete project.
     *
     * @return void
     */
    public function testSuperuserNonOwnerCanDelete()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'foo?69f',
            'is_superuser' => true
        ]);
        $this->assertTrue($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertTrue($user->can('delete', $this->project));
    }

    /**
     * Test if owner, non-superuser can delete project.
     *
     * @return void
     */
    public function testOwnerCanDelete()
    {
        $this->assertFalse($this->user->is_superuser);
        $this->assertEquals($this->user->id, $this->project->owner_id);
        $this->assertTrue($this->user->can('delete', $this->project));
    }

    /**
     * Test if non-superuser, non-owner can't delete project.
     *
     * @return void
     */
    public function testNonSuperuserNonOwnerCanNotDelete()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'foo?69f',
        ]);
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertFalse($user->can('delete', $this->project));
    }
}
