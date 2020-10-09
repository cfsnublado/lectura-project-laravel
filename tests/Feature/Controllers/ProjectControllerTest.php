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
     * Test if project stored successfully.
     *
     * @return void
     */
    public function testStoreSuccess()
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'This is a test project.'
        ];
        $this->assertFalse(Project::where('name', $data['name'])->exists());

        $this->actingAs($this->user);
        $response = $this->post(
            route('blog.project.store'),
            $data
        );
        $project = Project::where('name', $data['name'])->firstOrFail();
        $response->assertStatus(302);
        $response->assertRedirect(
            route('blog.project.show', ['slug' => $project->slug]),
        );
        $response->assertRedirect(
            route('blog.project.show', ['slug' => $project->slug]),
        );
        $this->assertEquals($project->owner_id, $this->user->id);
        $this->assertEquals($project->name, $data['name']);
        $this->assertEquals($project->description, $data['description']);
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

    // Access permissions

    /**
     * Test permissions for create.
     *
     * @return void
     */
    public function testPermissionsCreate()
    {
        // Unauthenticated
        $response = $this->get(
            route('blog.project.create')
        );
        $response->assertStatus(302);
        $response->assertRedirect(route('security.login'));

        // User
        $this->actingAs($this->user);
        $response = $this->get(
            route('blog.project.create')
        );
        $response->assertStatus(200);

        // Superuser
        $this->actingAs($this->superuser);
        $response = $this->get(
            route('blog.project.create')
        );
        $response->assertStatus(200);
    }

    /**
     * Test permissions for edit.
     *
     * @return void
     */
    public function testPermissionsEdit()
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
     * Test permissions for update.
     *
     * @return void
     */

    public function testPermissionsUpdate()
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
