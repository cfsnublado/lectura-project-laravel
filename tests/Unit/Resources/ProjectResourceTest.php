<?php

namespace Tests\Unit\Resources;

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
        $this->user = User::factory()->create();
        $this->user->refresh();
        $this->project = Project::factory()->create([
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
            'uuid' => $this->project->uuid,
            'name' => $this->project->name,
            'slug' => $this->project->slug,
            'description' => $this->project->description,
            'posts_url' => route('api.blog.project.posts.list', ['project' => $this->project->id])
        ];
        
        $this->assertEquals($data, $expectedData);
    }
}
