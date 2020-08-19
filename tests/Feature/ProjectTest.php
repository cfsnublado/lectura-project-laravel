<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
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
        $this->user = User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Foo?69f',
        ]);
        $this->user->refresh();
    }

    /**
     * Test if project updated successfully.
     *
     * @return void
     */

    public function testUpdateSuccess()
    {
        $data = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $project = Project::create($data);
        $this->be($this->user);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(302);
        $project->refresh();
        $this->assertEquals($project->name, $updatedData['name']);
        $this->assertEquals($project->description, $updatedData['description']);
    }

    /**
     * Test if unauthenticated user can't update project.
     *
     * @return void
     */

    public function testUpdateUnauthenticated()
    {
        $data = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $project = Project::create($data);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(403);
    }

    /**
     * Test if superuser, non-owner can update project.
     *
     * @return void
     */

    public function testUpdateSuperuserNonOwner()
    {
        $data = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Foo?69f',
            'is_superuser' => true
        ]);
        $user->refresh();
        $this->be($user);
        $project = Project::create($data);
        $this->assertTrue($user->is_superuser);
        $this->assertNotEquals($user->id, $project->owner_id);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(302);
        $project->refresh();
        $this->assertEquals($project->name, $updatedData['name']);
        $this->assertEquals($project->description, $updatedData['description']);
    }

    /**
     * Test if owner, non-superuser can update project.
     *
     * @return void
     */

    public function testUpdateOwnerNonSuperuser()
    {
        $data = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $this->be($this->user);
        $project = Project::create($data);
        $this->assertFalse($this->user->is_superuser);
        $this->assertEquals($this->user->id, $project->owner_id);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(302);
        $project->refresh();
        $this->assertEquals($project->name, $updatedData['name']);
        $this->assertEquals($project->description, $updatedData['description']);
    }

    /**
     * Test if non-superuser, non-owner can't update project.
     *
     * @return void
     */

    public function testUpdateNonSuperuserNonOwner()
    {
        $data = [
            'owner_id' => $this->user->id,
            'name' => 'Test Project',
            'description' => 'This is a test project'
        ];
        $updatedData = [
            'name' => 'Another Test Project',
            'description' => 'This is another test project.'
        ];
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Foo?69f',
        ]);
        $user->refresh();
        $this->be($user);
        $project = Project::create($data);
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $project->owner_id);
        $response = $this->post(
            route('blog.project.update', ['id' => $project->id]),
            $updatedData
        );
        $response->assertStatus(403);
    }
    
    /**
     * Test if unauthenticated user can't edit project.
     *
     * @return void
     */
    public function testEditUnauthenticated()
    {
        $project = Project::create([
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ]);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(403);
    }

    /**
     * Test if superuser, non-owner can edit project.
     *
     * @return void
     */
    public function testEditSuperuserNonOwner()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Foo?69f',
            'is_superuser' => true
        ]);
        $user->refresh();
        $this->be($user);
        $project = Project::create([
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ]);
        $this->assertTrue($user->is_superuser);
        $this->assertNotEquals($user->id, $project->owner_id);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(200);
    }

    /**
     * Test if owner, non-superuser can edit project.
     *
     * @return void
     */
    public function testEditOwnerNonSuperuser()
    {
        $this->be($this->user);
        $project = Project::create([
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ]);
        $this->assertFalse($this->user->is_superuser);
        $this->assertEquals($this->user->id, $project->owner_id);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(200);
    }

    /**
     * Test if non-superuser, non-owner can't edit project.
     *
     * @return void
     */
    public function testEditNonSuperuserNonOwner()
    {
        $user = User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => 'Foo?69f',
        ]);
        $user->refresh();
        $this->be($user);
        $project = Project::create([
            'owner_id' => $this->user->id,
            'name' => 'Test Project'
        ]);
        $this->assertFalse($user->is_superuser);
        $this->assertNotEquals($user->id, $project->owner_id);
        $response = $this->get(
            route('blog.project.edit', ['slug' => $project->slug])
        );
        $response->assertStatus(403);
    }
}
