<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SecurityTest extends DuskTestCase
{
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
}
