<?php

namespace Tests\Unit\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostAudioTest extends TestCase
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
        $this->project = Project::factory()->create([
            'owner_id' => $this->user->id,
        ]);
        $this->post = Post::factory()->create([
            'creator_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);
    }

    /**
     *
     */
    public function testEagerLoad()
    {
        PostAudio::factory()->create([
            'post_id' => $this->post->id,
            'creator_id' => $this->user->id,
        ]);
        $postAudio = PostAudio::where(
            [['post_id', $this->post->id], ['creator_id', $this->user->id]]
        )->firstOrFail();
    
        $this->assertTrue($postAudio->relationLoaded('post'));
        $this->assertTrue($postAudio->relationLoaded('creator'));
    }

    /**
     * Test if slug is generated when name is manipulated.
     *
     * @return void
     */
    public function testSlugCreatedFromName()
    {
        $name = 'Test Post Audio';
        $slug = Str::slug($name, '-');
        $postAudio = PostAudio::create([
            'creator_id' => $this->user->id,
            'post_id' => $this->post->id,
            'name' => $name,
            'description' => 'This is a test post audio',
            'audio_url' => 'https://foo.com/foo.mp3',
        ]);

        $this->assertEquals($postAudio->slug, $slug);
    }
}
