<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/security/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@username' => 'input[name=username]',
            '@password' => 'input[name=password]',
            '@loginBtn' => '#login-btn',
        ];
    }

    public function loginForm(Browser $browser, $username, $password)
    {
        $browser->type('@username', $username)
        ->type('@password', $password)
        ->press('@loginBtn');
    }
}
