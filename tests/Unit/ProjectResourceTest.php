<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Http\Resources\Blog\Project as ProjectResource;

class ProjectResourceTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = factory(User::class)->create();
        $this->user->refresh();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
            'name' => 'Test project'
        ]);
    }

    /**
     *
     */
    public function testToArray()
    {
        $projectResource = new ProjectResource($this->project);
        $data = $projectResource->toArray(request());
        $expectedData = [
            'id' => $this->project->id,
            'name' => $this->project->name,
            'slug' => $this->project->slug,
            'description' => $this->project->description,
        ];
        
        $this->assertEquals($data, $expectedData);
    }
}
