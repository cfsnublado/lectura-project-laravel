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

    private $superuser;
    private $projectOwner;
    private $admin;
    private $editor;
    private $author;
    private $nonMember;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->nonMember = factory(User::class)->create();
        $this->superuser = factory(User::class)->create([
            'is_superuser' => true
        ]);
        $this->projectOwner = factory(User::class)->create();
        $this->project = factory(Project::class) ->create([
            'owner_id' => $this->projectOwner->id
        ]);
        $this->admin = factory(User::class)->create();
        ProjectMember::create([
            'member_id' => $this->admin->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_ADMIN
        ]);
        $this->editor = factory(User::class)->create();
        ProjectMember::create([
            'member_id' => $this->editor->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_EDITOR
        ]);
        $this->author = factory(User::class)->create();
        ProjectMember::create([
            'member_id' => $this->author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);
    }

    /**
     *
     */
    public function testUpdate()
    {
        $this->assertTrue($this->superuser->can('update', $this->project));
        $this->assertTrue($this->projectOwner->can('update', $this->project));
        $this->assertFalse($this->admin->can('update', $this->project));
        $this->assertFalse($this->editor->can('update', $this->project));
        $this->assertFalse($this->author->can('update', $this->project));
        $this->assertFalse($this->nonMember->can('update', $this->project));
    }

    /**
     *
     */
    public function testDelete()
    {
        $this->assertTrue($this->superuser->can('delete', $this->project));
        $this->assertTrue($this->projectOwner->can('delete', $this->project));
        $this->assertFalse($this->admin->can('delete', $this->project));
        $this->assertFalse($this->editor->can('delete', $this->project));
        $this->assertFalse($this->author->can('delete', $this->project));
        $this->assertFalse($this->nonMember->can('delete', $this->project));
    }

    /**
     *
     */
    public function testCreatePost()
    {
        $this->assertFalse($this->superuser->can('createPost', $this->project));
        $this->assertTrue($this->projectOwner->can('createPost', $this->project));
        $this->assertTrue($this->admin->can('createPost', $this->project));
        $this->assertTrue($this->editor->can('createPost', $this->project));
        $this->assertTrue($this->author->can('createPost', $this->project));
        $this->assertFalse($this->nonMember->can('createPost', $this->project));
    }
}
