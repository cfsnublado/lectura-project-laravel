<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\LoginPage;
use App\Models\User\User;
use App\Models\Blog\Project;

class SecurityTest extends DuskTestCase
{
    use DatabaseTransactions;

    /**
     * Test if a successful login redirects the user 
     * to the previous page.
     *
     * @return void
     */
    public function testLoginRedirectsToPreviousPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/secret')
            ->click('#navbar-login-link')
            ->waitForLocation('/security/login')
            ->on(new LoginPage)
            ->loginForm('cfs', 'Pizza?69p')
            ->waitForLocation('/secret')
            ->assertAuthenticated()
            ->logout();
        });
    }

    /**
     * Test if a page that requires authorization redirects the user 
     * to the login page.
     *
     * @return void
     */
    public function testAuthRequiredRedirectsToLoginPage()
    {
        $project = Project::where('name', 'Project A')->firstOrFail();

        $this->browse(function (Browser $browser) use ($project) {
            $browser->visit(route('blog.project.edit', ['slug' => $project->slug]))
            ->waitForLocation('/security/login')
            ->on(new LoginPage)
            ->loginForm('cfs', 'Pizza?69p')
            ->waitForRoute('blog.project.edit', ['slug' => $project->slug])
            ->assertAuthenticated()
            ->logout();
        });
    }
}
