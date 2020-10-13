<?php

namespace Tests\Unit\Models;

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
        $this->user = User::factory()->create();
        $this->user->refresh();
    }

    /**
     *
     */
    public function testEagerLoad()
    {
        Project::factory()->create(
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
        $project = Project::factory()->create(
            ['name' => $name, 'owner_id' => $this->user->id]
        );

        $this->assertEquals($project->slug, $slug);
    }

    /**
     * Test uuid value. It should be generated only
     * if not provided in the constructor.
     *
     * @return void
     */
    public function testUuidProvidedInConstructor()
    {
        $uuid = '7e204342-62c6-4b94-b177-f97acd6ec5af';
        $project = Project::factory()->create(
            [
                'owner_id' => $this->user->id,
                'uuid' => $uuid,
                'name' => $name,
            ]
        );
        $project->refresh();
        $this->assertEquals($project->uuid, $uuid);
    }

    /**
     * Test if uuid value generated if it's not provided
     * in the constructor.
     *
     * @return void
     */
    public function testUuidGeneratedOnCreate()
    {
        $user = User::factory()->create(['id' => '']);
        $project = Project::factory()->create(
            [
                'owner_id' => $this->user->id,
                'uuid' => '',
                'name' => $name,
            ]
        );
        $this->assertTrue(is_string($project->uuid));
        $this->assertEquals(mb_strlen($project->uuid, 'utf8'), 36);
    }
}
