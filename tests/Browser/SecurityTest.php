<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\LoginPage;
use App\Models\User\User;

class SecurityTest extends DuskTestCase
{
    use DatabaseTransactions;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/security/login')
            ->waitFor('#login-btn')
            ->click('#login-btn')
            ->waitFor('#login-btn')
            ->assertSee('Sign in');
        });
    }

    /**
     * Test if a successful login redirects the user to the previous page.
     *
     * @return void
     */
    public function testLoginRedirectsToPreviousPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/secret')
            ->click('#navbar-login-link')
            ->on(new LoginPage)
            ->loginForm('cfs', 'Pizza?69p')
            ->assertPathIs('/secret')
            ->assertAuthenticated();
        });
    }
}
