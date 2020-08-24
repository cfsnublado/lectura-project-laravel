<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\ProjectsPage;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectTest extends DuskTestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --env=testing');
        $this->user = User::where('username', 'cfs')->firstOrFail();
        $this->user->refresh();
    }

    /**
     * Test the deletion of a project from the project box.
     *
     * @return void
     */
    public function testDeleteProjectFromBox()
    {
        $user = $this->user;
        $project = Project::where('name', 'Project A')->firstOrFail();
        $projectId = $project->id;
        $this->browse(function (Browser $browser) use ($user, $projectId) {
            $browser->loginAs($user)
            ->visit(new ProjectsPage())
            ->waitForProjects()
            ->deleteProjectAjax($projectId)
            ->visit(new ProjectsPage())
            ->waitForProjects()
            ->checkNoProject($projectId);
        });

        $this->assertFalse(Project::where('id', $projectId)->exists());
    }
}
