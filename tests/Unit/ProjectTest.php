<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = factory(User::class)->create();
        $this->user->refresh();
    }

    /**
     *
     */
    public function testEagerLoad()
    {
        factory(Project::class)->create(
            ['name' => 'Test project', 'owner_id' => $this->user->id]
        );
        $project = Project::where('name', 'Test project')->firstOrFail();
    
        $this->assertTrue($project->relationLoaded('owner'));
    }

    /**
     * Test if slug is generated when name is manipulated.
     *
     * @return void
     */
    public function testSlugCreatedFromName()
    {
        $name = 'Test Project';
        $slug = Str::slug($name, '-');
        $project = factory(Project::class)->create(
            ['name' => $name, 'owner_id' => $this->user->id]
        );

        $this->assertEquals($project->slug, $slug);
    }
}
