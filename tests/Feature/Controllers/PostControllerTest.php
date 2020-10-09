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

        // User non-member of project
        $this->user = User::factory()->create();

        // Superuser non-member of project
        $this->superuser = User::factory()->create([
            'is_superuser' => true
        ]);
        $this->superuser->refresh();

        // Owner of project
        $this->projectOwner = User::factory()->create();
        $this->projectOwner->refresh();
        
        $this->project = Project::factory()->create([
            'owner_id' => $this->projectOwner,
            'name' => 'Test project A'
        ]);

        // Member of project with author role
        $this->author = User::factory()->create();
        $this->author->refresh();
        ProjectMember::create([
            'member_id' => $this->author->id,
            'project_id' => $this->project->id,
            'role' => ProjectMember::ROLE_AUTHOR
        ]);
    }

    /**
     * Test store success.
     *
     * @return void
     */

    public function testStoreSuccess()
    {
        $data = [
            'language' => 'es',
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

        $this->assertEquals($post->creator_id, $this->projectOwner->id);
        $this->assertEquals($post->language, $data['language']);
        $this->assertEquals($post->name, $data['name']);
        $this->assertEquals($post->description, $data['description']);
    }

    /**
     * Test if post updated successfully.
     *
     * @return void
     */

    public function testUpdateSuccess()
    {
        $data = [
            'project_id' => $this->project->id,
            'creator_id' => $this->author->id,
            'language' => 'en',
            'name' => 'Test Post',
            'description' => 'This is a test post',
            'content' => 'This is some content.'
        ];
        $updatedData = [
            'language' => 'es',
            'name' => 'Another Test Post',
            'description' => 'This is another test post.',
            'content' => 'This is some more content'
        ];
        $post = Post::create($data);
        $this->actingAs($this->author);
        $response = $this->post(
            route('blog.post.update', ['id' => $post->id]),
            $updatedData
        );
        $post->refresh();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.post.show', ['slug' => $post->slug]),
        );

        $this->assertEquals($post->language, $updatedData['language']);
        $this->assertEquals($post->name, $updatedData['name']);
        $this->assertEquals($post->description, $updatedData['description']);
        $this->assertEquals($post->content, $updatedData['content']);
    }

    // Access permissions

    /**
     * Test permissions for create.
     *
     * @return void
     */

    public function testPermissionsCreate()
    {
        // Unathenticated
        $response = $this->get(
            route('blog.post.create', ['project_slug' => $this->project->slug])
        );
        $response->assertStatus(302);
        $response->assertRedirect(route('security.login'));

        // User non-member
        $this->actingAs($this->user);
        $response = $this->get(
            route('blog.post.create', ['project_slug' => $this->project->slug])
        );
        $response->assertStatus(403);

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
     * Test permissions for store.
     *
     * @return void
     */

    public function testPermissionsStore()
    {
        $data = [
            'language' => 'en',
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

        // User non-member
        $this->actingAs($this->user);
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
