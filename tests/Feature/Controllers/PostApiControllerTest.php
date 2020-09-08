<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;
use App\Models\Blog\Post;

class PostApiControllerTest extends TestCase
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
        $this->superuser = factory(User::class)->create([
            'is_superuser' => true
        ]);
        $this->user = factory(User::class)->create();
        $this->projectOwner = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->projectOwner,
            'name' => 'Test project A'
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
     * @return void
     */
    public function testDelete()
    {

        $postName = 'Test post';
        $post = factory(Post::class)->create([
            'creator_id' => $this->projectOwner->id,
            'name' => $postName
        ]);

        // Unauthenticated
        $response = $this->delete(
            route('api.blog.post.destroy', ['post' => $post->id])
        );
        $response->assertStatus(403);
        $this->assertTrue(
            Post::where('name', $postName)->exists()
        );

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->delete(
            route('api.blog.post.destroy', ['post' => $post->id])
        );
        $response->assertStatus(204);
        $this->assertFalse(
            Post::where('name', $postName)->exists()
        );

        $post = factory(Post::class)->create([
            'creator_id' => $this->projectOwner->id,
            'name' => $postName
        ]);

        // Project owner
        $this->actingAs($this->projectOwner);
        $response = $this->delete(
            route('api.blog.post.destroy', ['post' => $post->id])
        );
        $response->assertStatus(204);
        $this->assertFalse(
            Post::where('name', $postName)->exists()
        );

        $post = factory(Post::class)->create([
            'creator_id' => $this->projectOwner->id,
            'name' => $postName
        ]);

        // User
        $this->actingAs($this->user);
        $response = $this->delete(
            route('api.blog.post.destroy', ['post' => $post->id])
        );
        $response->assertStatus(403);
        $this->assertTrue(
            Post::where('name', $postName)->exists()
        );
    }

    /**
     *
     * @return void
     */
    public function testImport()
    {
        $this->assertFalse(
            Post::where([
                ['project_id', $this->project->id],
                ['creator_id', $this->projectOwner->id],
                ['name', 'Import post']
            ])->exists()
        );

        $response = $this->json(
            'POST',
            route('api.user.token'),
            [
                'username' => $this->projectOwner->username,
                'password' => 'Pizza?69p'
            ]
        );

        $response->assertStatus(200);
        $token = json_decode($response->getContent())->token;

        $response = $this->json(
            'POST',
            route('api.blog.post.import'),
            [
                'project_name' => $this->project->name,
                'name' => 'Import post',
                'description' => 'An imported post',
                'content' => 'Imported post content',
                'post_audios' => []
            ],
            ['Authorization' => 'Bearer ' . $token]
        );
        $response->assertStatus(200);

        $this->assertTrue(
            Post::where([
                ['project_id', $this->project->id],
                ['creator_id', $this->projectOwner->id],
                ['name', 'Import post']
            ])->exists()
        );
    }

    /**
     *
     * @return void
     */
    public function testImportAccess()
    {
        $response = $this->json(
            'POST',
            route('api.user.token'),
            [
                'username' => $this->user->username,
                'password' => 'Pizza?69p'
            ]
        );

        $response->assertStatus(200);
        $token = json_decode($response->getContent())->token;

        $response = $this->json(
            'POST',
            route('api.blog.post.import'),
            [
                'project_name' => $this->project->name,
                'name' => 'Import post',
                'description' => 'An imported post',
                'content' => 'Imported post content',
                'post_audios' => []
            ],
            ['Authorization' => 'Bearer ' . $token]
        );
        $response->assertStatus(403);
        $this->assertFalse(
            Post::where([
                ['project_id', $this->project->id],
                ['creator_id', $this->user->id],
                ['name', 'Import post']
            ])->exists()
        );
    }
}
