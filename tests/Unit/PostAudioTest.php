<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Model\User\User;
use App\Model\Blog\Project;
use App\Model\Blog\Post;
use App\Model\Blog\PostAudio;

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
        $this->user = User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        $this->project = Project::create([
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
            'description' => 'This is a test project',
        ]);
        $this->post = Post::create([
            'creator_id' => $this->user->id,
            'project_id' => $this->project->id,
            'name' => 'Test Post',
            'description' => 'This is a test post',
        ]);
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
