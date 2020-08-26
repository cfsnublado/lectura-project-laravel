<?php

namespace Tests\Unit;

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
        $this->user = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);
    }

    /**
     * Test if slug is generated when name is manipulated.
     *
     * @return void
     */
    public function testSlugCreatedFromName()
    {
        $post = factory(Post::class)->create([
            'creator_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);
        $post->refresh();
        $name = $post->name;
        $slug = Str::slug($name, '-');

        $this->assertEquals($post->slug, $slug);
    }
}
