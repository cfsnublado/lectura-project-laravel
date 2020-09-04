<?php

namespace Tests\Unit;

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
        $this->nonMember = factory(User::class)->create();
        $this->superuser = factory(User::class)->create([
            'is_superuser' => true
        ]);
        $this->projectOwner = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
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
        $this->author2 = factory(User::class)->create();
        ProjectMember::create([
            'member_id' => $this->author2->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);
        $this->post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
        $post = factory(Post::class)->create([
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
