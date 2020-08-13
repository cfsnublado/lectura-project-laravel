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
    }

    /**
     * Test if slug is generated when name is manipulated.
     *
     * @return void
     */
    public function testSlugCreatedFromName()
    {
        $name = 'Test Post';
        $slug = Str::slug($name, '-');
        $post = Post::create([
            'creator_id' => $this->user->id,
            'project_id' => $this->project->id,
            'name' => $name,
            'description' => 'This is a test post',
        ]);

        $this->assertEquals($post->slug, $slug);
    }
}
