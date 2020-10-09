<?php

namespace Tests\Unit\Resources;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;
use App\Http\Resources\Blog\PostAudio as PostAudioResource;

class PostAudioResourceTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;
    private $post;
    private $postAudio;

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
        $this->postAudio = PostAudio::factory()->create([
            'post_id' => $this->post->id,
            'creator_id' => $this->user->id,
        ]);
    }

    /**
     *
     */
    public function testToArray()
    {
        $postAudioResource = new PostAudioResource($this->postAudio);
        $data = $postAudioResource->toArray(request());
        $expectedData = [
            'id' => $this->postAudio->id,
            'name' => $this->postAudio->name,
            'slug' => $this->postAudio->slug,
            'description' => $this->postAudio->description,
            'audio_url' => $this->postAudio->audio_url,
            'creator_id' => $this->postAudio->creator_id,
            'creator_username' => $this->postAudio->creator->username,
            'creator_first_name' => $this->postAudio->creator->first_name,
            'creator_last_name' => $this->postAudio->creator->last_name,
            'post_id' => $this->postAudio->post_id,
            'post_name' => $this->postAudio->post->name,
            'post_slug' => $this->postAudio->post->slug,
            'post_url' => route(
                'api.blog.post.show',
                ['post' => $this->postAudio->post_id]
            )
        ];

        $this->assertEquals($data, $expectedData);
    }
}
