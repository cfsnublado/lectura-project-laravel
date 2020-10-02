<?php

namespace Tests\Unit\Resources;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Http\Resources\Blog\Post as PostResource;

class PostResourceTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;
    private $post;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = User::factory()->create();
        $this->user->refresh();
        $this->project = Project::factory()->create([
            'owner_id' => $this->user->id,
            'name' => 'Test project'
        ]);
        $this->post = Post::factory()->create([
            'project_id' => $this->project->id,
            'creator_id' => $this->user->id,
            'name' => 'Test post',
        ]);
    }

    /**
     *
     */
    public function testToArray()
    {
        $postResource = new PostResource($this->post);
        $data = $postResource->toArray(request());
        $expectedData = [
            'id' => $this->post->id,
            'language' => $this->post->language,
            'name' => $this->post->name,
            'slug' => $this->post->slug,
            'description' => $this->post->description,
            'project_url' => route(
                'api.blog.project.show',
                ['project' => $this->post->project_id]
            ),
            'post_audios_url' => route(
                'api.blog.post.post_audios.list',
                ['post' => $this->post->id]
            )
        ];

        $this->assertEquals($data, $expectedData);
    }
}
