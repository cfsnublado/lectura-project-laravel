<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AppTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLanguageChanger()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertSee('Lectura')
            ->openSidebar()
            ->click('#sidebar-language-selector')
            ->waitFor('#sidebar-language-es')
            ->click('#sidebar-language-es')
            ->assertSee('Comparte lecturas y practica tu pronunciación.')
            ->openSidebar()
            ->click('#sidebar-language-selector')
            ->waitFor('#sidebar-language-en')
            ->click('#sidebar-language-en')
            ->assertSee('Share readings and practice your pronunciation.');
        });
    }
}
