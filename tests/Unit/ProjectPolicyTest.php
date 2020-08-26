<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;

class ProjectPolicyTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = factory(User::class)->create();
        $this->project = factory(Project::class) ->create([
            'owner_id' => $this->user->id
        ]);
    }

    /**
     * Test if superuser, non-owner can update project.
     *
     * @return void
     */
    public function testSuperuserNonOwnerCanUpdate()
    {
        $user = factory(User::class)->create([
            'is_superuser' => true,
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
        $user = factory(User::class)->create();
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
        $user = factory(User::class)->create([
            'is_superuser' => true,
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
        $user = factory(User::class)->create();
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertFalse($user->can('delete', $this->project));
    }

    /**
     * Test if owner can create a project post.
     *
     * @return void
     */
    public function testOwnerCanCreatePost()
    {
        $this->assertFalse($this->user->is_superuser);
        $this->assertEquals($this->user->id, $this->project->owner_id);
        $this->assertTrue($this->user->can('createPost', $this->project));
    }

    /**
     * Test if project team member can create a project post.
     *
     * @return void
     */
    public function testMemberCanCreatePost()
    {
        $user = factory(User::class)->create();
        ProjectMember::create([
            'project_id' => $this->project->id,
            'member_id' => $user->id,
        ]);
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertTrue($user->can('createPost', $this->project));
    }

    /**
     * Test if superuser, non-member can not create a project post.
     *
     * @return void
     */
    public function testSuperuserNonMemberCanNotCreatePost()
    {
        $user = factory(User::class)->create([
            'is_superuser' => true,
        ]);
        $this->assertTrue($user->is_superuser);
        $this->assertNotEquals($user->id, $this->project->owner_id);
        $this->assertFalse($user->can('createPost', $this->project));
    }

    /**
     * Test if non-owner, non-member can't create project post.
     *
     * @return void
     */
    public function testNonOwnerNonMemberCanNotCreatePost()
    {
        $user = factory(User::class)->create();
        $this->assertFalse($user->is_superuser);
        $this->assertFalse($user->can('createPost', $this->project));
    }
}
