<?php

namespace Tests\Unit\Policies;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\ProjectMember;

class PostPolicyTest extends TestCase
{
    use DatabaseTransactions;

    private $superuser;
    private $projectOwner;
    private $admin;
    private $editor;
    private $author;
    private $nonMember;
    private $project;
    private $post;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->nonMember = User::factory()->create();
        $this->superuser = User::factory()->create([
            'is_superuser' => true
        ]);
        $this->projectOwner = User::factory()->create();
        $this->project = Project::factory()->create([
            'owner_id' => $this->projectOwner->id
        ]);
        $this->admin = User::factory()->create();
        ProjectMember::create([
            'member_id' => $this->admin->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_ADMIN
        ]);
        $this->editor = User::factory()->create();
        ProjectMember::create([
            'member_id' => $this->editor->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_EDITOR
        ]);
        $this->author = User::factory()->create();
        ProjectMember::create([
            'member_id' => $this->author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);
        $this->author2 = User::factory()->create();
        ProjectMember::create([
            'member_id' => $this->author2->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);
        $this->post = Post::factory()->create([
            'creator_id' => $this->author->id,
            'project_id' => $this->project->id,
        ]);
    }

    /**
     * Test permissions for update.
     *
     * @return void
     */
    public function testUpdate()
    {
        // Author-created post
        $post = Post::factory()->create([
            'creator_id' => $this->author->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('update', $post));
        $this->assertTrue($this->projectOwner->can('update', $post));
        $this->assertTrue($this->admin->can('update', $post));
        $this->assertTrue($this->editor->can('update', $post));
        $this->assertTrue($this->author->can('update', $post));
        $this->assertFalse($this->author2->can('update', $post));
        $this->assertFalse($this->nonMember->can('update', $post));

        // Editor-created post
        $post = Post::factory()->create([
            'creator_id' => $this->editor->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('update', $post));
        $this->assertTrue($this->projectOwner->can('update', $post));
        $this->assertTrue($this->admin->can('update', $post));
        $this->assertTrue($this->editor->can('update', $post));
        $this->assertFalse($this->author->can('update', $post));
        $this->assertFalse($this->nonMember->can('update', $post));

        // Admin-created post
        $post = Post::factory()->create([
            'creator_id' => $this->admin->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('update', $post));
        $this->assertTrue($this->projectOwner->can('update', $post));
        $this->assertTrue($this->admin->can('update', $post));
        $this->assertTrue($this->editor->can('update', $post));
        $this->assertFalse($this->author->can('update', $post));
        $this->assertFalse($this->nonMember->can('update', $post));

        // Admin-created post
        $post = Post::factory()->create([
            'creator_id' => $this->admin->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('update', $post));
        $this->assertTrue($this->projectOwner->can('update', $post));
        $this->assertTrue($this->admin->can('update', $post));
        $this->assertTrue($this->editor->can('update', $post));
        $this->assertFalse($this->author->can('update', $post));
        $this->assertFalse($this->nonMember->can('update', $post));

        // Owner-created post
        $post = Post::factory()->create([
            'creator_id' => $this->projectOwner->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('update', $post));
        $this->assertTrue($this->projectOwner->can('update', $post));
        $this->assertTrue($this->admin->can('update', $post));
        $this->assertTrue($this->editor->can('update', $post));
        $this->assertFalse($this->author->can('update', $post));
        $this->assertFalse($this->nonMember->can('update', $post));
    }

    /**
     * Test permissions for delete.
     *
     * @return void
     */
    public function testDelete()
    {
        // Author-created post
        $post = Post::factory()->create([
            'creator_id' => $this->author->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('delete', $post));
        $this->assertTrue($this->projectOwner->can('delete', $post));
        $this->assertTrue($this->admin->can('delete', $post));
        $this->assertTrue($this->editor->can('delete', $post));
        $this->assertTrue($this->author->can('delete', $post));
        $this->assertFalse($this->author2->can('delete', $post));
        $this->assertFalse($this->nonMember->can('delete', $post));

        // Editor-created post
        $post = Post::factory()->create([
            'creator_id' => $this->editor->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('delete', $post));
        $this->assertTrue($this->projectOwner->can('delete', $post));
        $this->assertTrue($this->admin->can('delete', $post));
        $this->assertTrue($this->editor->can('delete', $post));
        $this->assertFalse($this->author->can('delete', $post));
        $this->assertFalse($this->nonMember->can('delete', $post));

        // Admin-created post
        $post = Post::factory()->create([
            'creator_id' => $this->admin->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('delete', $post));
        $this->assertTrue($this->projectOwner->can('delete', $post));
        $this->assertTrue($this->admin->can('delete', $post));
        $this->assertTrue($this->editor->can('delete', $post));
        $this->assertFalse($this->author->can('delete', $post));
        $this->assertFalse($this->nonMember->can('delete', $post));

        // Admin-created post
        $post = Post::factory()->create([
            'creator_id' => $this->admin->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('delete', $post));
        $this->assertTrue($this->projectOwner->can('delete', $post));
        $this->assertTrue($this->admin->can('delete', $post));
        $this->assertTrue($this->editor->can('delete', $post));
        $this->assertFalse($this->author->can('delete', $post));
        $this->assertFalse($this->nonMember->can('delete', $post));

        // Owner-created post
        $post = Post::factory()->create([
            'creator_id' => $this->projectOwner->id,
            'project_id' => $this->project->id,
        ]);
        $this->assertTrue($this->superuser->can('delete', $post));
        $this->assertTrue($this->projectOwner->can('delete', $post));
        $this->assertTrue($this->admin->can('delete', $post));
        $this->assertTrue($this->editor->can('delete', $post));
        $this->assertFalse($this->author->can('delete', $post));
        $this->assertFalse($this->nonMember->can('delete', $post));
    }
}
