<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;
use App\Models\Blog\Post;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $superuser;
    private $projectOwner;
    private $author;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->superuser = User::factory()->create([
            'is_superuser' => true
        ]);
        $this->superuser->refresh();
        $this->projectOwner = User::factory()->create();
        $this->projectOwner->refresh();
        $this->project = Project::factory()->create([
            'owner_id' => $this->projectOwner,
            'name' => 'Test project A'
        ]);
        $this->author = User::factory()->create();
        $this->author->refresh();
        ProjectMember::create([
            'member_id' => $this->author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);
    }

    /**
     * Test if project updated successfully.
     *
     * @return void
     */

    public function testStoreSuccess()
    {
        $data = [
            'name' => 'Test Post',
            'description' => 'This is a test post',
            'content' => 'Test content'
        ];
        $this->assertFalse(Post::where('name', $data['name'])->exists());
        $this->actingAs($this->projectOwner);
        $response = $this->post(
            route('blog.post.store', ['project_id' => $this->project->id]),
            $data
        );
        $response->assertStatus(302);
        $post = Post::where('name', $data['name'])->firstOrFail();
        $response->assertRedirect(
            route('blog.post.show', ['slug' => $post->slug]),
        );
    }

    /**
     *
     * @return void
     */

    public function testCreate()
    {
        // Unathenticated
        $response = $this->get(
            route('blog.post.create', ['project_slug' => $this->project->slug])
        );
        $response->assertStatus(302);
        $response->assertRedirect(route('security.login'));

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->get(
            route('blog.post.create', ['project_slug' => $this->project->slug])
        );
        $response->assertStatus(403);

        // Project owner
        $this->actingAs($this->projectOwner);
        $response = $this->get(
            route('blog.post.create', ['project_slug' => $this->project->slug])
        );
        $response->assertStatus(200);

        // Author
        $this->actingAs($this->author);
        $response = $this->get(
            route('blog.post.create', ['project_slug' => $this->project->slug])
        );
        $response->assertStatus(200);
    }

    /**
     *
     * @return void
     */

    public function testStore()
    {
        $data = [
            'name' => 'Test Post',
            'description' => 'This is a test post',
            'content' => 'This is some content.'
        ];

        // Unauthenticated
        $response = $this->post(
            route('blog.post.store', ['project_id' => $this->project->id]),
            $data
        );
        $response->assertStatus(403);

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->post(
            route('blog.post.store', ['project_id' => $this->project->id]),
            $data
        );
        $response->assertStatus(403);

        // Project owner
        $this->actingAs($this->projectOwner);
        $response = $this->post(
            route('blog.post.store', ['project_id' => $this->project->id]),
            $data
        );
        $post = Post::where('name', $data['name'])->firstOrFail();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.post.show', ['slug' => $post->slug]),
        );
        $post->delete();

        // Author
        $this->actingAs($this->author);
        $response = $this->post(
            route('blog.post.store', ['project_id' => $this->project->id]),
            $data
        );
        $post = Post::where('name', $data['name'])->firstOrFail();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.post.show', ['slug' => $post->slug]),
        );
        $post->delete();
    }
}
