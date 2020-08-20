<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectApiTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Foo?69f',
        ]);
    }

    // PERMISSIONS
    
    /**
     * Test if unauthenticated user can't delete model.
     *
     * @return void
     */
    public function testDeleteUnauthenticated()
    {
        $projectData = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ];
        $project = Project::create($projectData);
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
    }

    /**
     * Test if superuser, non-owner can delete model.
     *
     * @return void
     */
    public function testDeleteSuperUserNonOwner()
    {
        $projectData = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ];
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Foo?69f',
            'is_superuser' => true
        ]);
        $this->be($user);
        $project = Project::create($projectData);
        $this->assertTrue($user->is_superuser);
        $this->assertNotEquals($user->user_id, $project->owner_id);
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
    }

    /**
     * Test if owner, non-superuser, can delete model.
     *
     * @return void
     */
    public function testDeleteOwnerNonSuperuser()
    {
        $this->be($this->user);

        $projectData = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ];
        $project = Project::create($projectData);
        $this->assertFalse($this->user->is_superuser);
        $this->assertEquals($this->user->id, $project->owner_id);
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
    }

    /**
     * Test if non-superuser, non-owner user can't delete model.
     *
     * @return void
     */
    public function testDeleteNonSuperUserNonOwner()
    {
        $projectData = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ];
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Foo?69f',
        ]);
        $this->be($user);
        $project = Project::create($projectData);
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $project->owner_id);
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
