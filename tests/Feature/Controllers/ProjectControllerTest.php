<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectControllerTest extends TestCase
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
        $this->superuser->refresh();
        $this->user = User::factory()->create();
        $this->user->refresh();
        $this->projectOwner = User::factory()->create();
        $this->projectOwner->refresh();
    }

    /**
     * Test if project updated successfully.
     *
     * @return void
     */

    public function testUpdateSuccess()
    {
        $data = [
            'owner_id' => $this->projectOwner->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $project = Project::create($data);
        $this->actingAs($this->projectOwner);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $project->refresh();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.project.show', ['slug' => $project->slug]),
        );
        $this->assertEquals($project->name, $updatedData['name']);
        $this->assertEquals($project->description, $updatedData['description']);
    }

    /**
     *
     * @return void
     */
    public function testEdit()
    {
        $project = Project::factory()->create(
            ['owner_id' => $this->projectOwner->id]
        );

        // Unauthenticated
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(302);
        $response->assertRedirect(route('security.login'));

        // User
        $this->actingAs($this->user);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(403);

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(200);

        // Project owner
        $this->actingAs($this->projectOwner);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(200);
    }

    /**
     *
     * @return void
     */

    public function testUpdate()
    {
        $data = [
            'owner_id' => $this->projectOwner->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $project = Project::create($data);

        // Unauthenticated
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(403);

        // User
        $this->actingAs($this->user);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(403);

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $project->refresh();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.project.show', ['slug' => $project->slug]),
        );
        $project->delete();
        $project = Project::create($data);

        // Project owner
        $this->actingAs($this->projectOwner);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $project->refresh();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.project.show', ['slug' => $project->slug]),
        );
    }
}
