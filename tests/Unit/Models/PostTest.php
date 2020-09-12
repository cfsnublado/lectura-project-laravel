<?php

namespace Tests\Unit\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create([
            'owner_id' => $this->user->id,
        ]);
    }

    /**
     *
     */
    public function testEagerLoad()
    {
        Post::factory()->create([
            'name' => 'Test post',
            'creator_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);

        $post = Post::where('name', 'Test post')->firstOrFail();
    
        $this->assertTrue($post->relationLoaded('creator'));
        $this->assertTrue($post->relationLoaded('project'));
    }

    /**
     * Test if slug is generated when name is manipulated.
     *
     * @return void
     */
    public function testSlugCreatedFromName()
    {
        $post = Post::factory()->create([
            'creator_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);
        $post->refresh();
        $name = $post->name;
        $slug = Str::slug($name, '-');

        $this->assertEquals($post->slug, $slug);
    }
}
