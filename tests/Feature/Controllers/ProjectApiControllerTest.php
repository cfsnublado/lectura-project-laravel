<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $superuser;
    private $user;
    private $projectOwner;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->superuser = User::factory()->create([
            'is_superuser' => true
        ]);
        $this->user = User::factory()->create();
        $this->projectOwner = User::factory()->create();
    }
    
    /**
     *
     * @return void
     */
    public function testDelete()
    {
        $projectData = [
            'owner_id' => $this->projectOwner->id,
            'name' => 'Test Project'
        ];
        $project = Project::create($projectData);

        // Unauthenticated
        $response = $this->delete(
            route('api.blog.project.destroy', ['project' => $project->id])
        );
        $response->assertStatus(403);
        $this->assertTrue(
            Project::where([
                ['owner_id', '=', $projectData['owner_id']],
                ['name', '=', $projectData['name']]
            ])->exists()
        );

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->delete(
            route('api.blog.project.destroy', ['project' => $project->id])
        );
        $response->assertStatus(204);
        $this->assertFalse(
            Project::where([
                ['owner_id', $projectData['owner_id']],
                ['name', $projectData['name']]
            ])->exists()
        );

        // Project owner
        $project = Project::create($projectData);
        $this->actingAs($this->projectOwner);
        $response = $this->delete(
            route('api.blog.project.destroy', ['project' => $project->id])
        );
        $response->assertStatus(204);
        $this->assertFalse(
            Project::where([
                ['owner_id', $projectData['owner_id']],
                ['name', $projectData['name']]
            ])->exists()
        );

        // User
        $project = Project::create($projectData);
        $this->actingAs($this->user);
        $response = $this->delete(
            route('api.blog.project.destroy', ['project' => $project->id])
        );
        $response->assertStatus(403);
        $this->assertTrue(
            Project::where([
                ['owner_id', $projectData['owner_id']],
                ['name', $projectData['name']]
            ])->exists()
        );
    }
}
