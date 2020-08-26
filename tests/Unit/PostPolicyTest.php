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

class ProjectPolicyTest extends TestCase
{
    use DatabaseTransactions;

    private $projectOwner;
    private $admin;
    private $adminRole;
    private $editor;
    private $editorRole;
    private $author;
    private $authorRole;
    private $nonMember;
    private $project;
    private $post;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->nonMember = factory(User::class)->create();
        $this->projectOwner = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->projectOwner->id
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

        $this->post = factory(Post::class)->create([
            'creator_id' => $this->author->id,
            'project_id' => $this->project->id,
        ]);
    }

    /**
     * Test if superuser, non-owner can update post.
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
        $this->assertTrue($user->can('update', $this->post));
    }
}
