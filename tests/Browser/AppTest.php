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
            $headerEn = 'Share readings and practice your pronunciation.';
            $headerEs = 'Comparte lecturas y practica tu pronunciación.';
            
            $browser->visit('/')
            ->assertSee($headerEn)
            ->openSidebar()
            ->click('#sidebar-language-selector')
            ->waitFor('#sidebar-language-es')
            ->click('#sidebar-language-es')
            ->assertSee($headerEs)
            ->openSidebar()
            ->click('#sidebar-language-selector')
            ->waitFor('#sidebar-language-en')
            ->click('#sidebar-language-en')
            ->assertSee($headerEn);

            $headerEn = 'Hello!';
            $headerEs = '¡Hola!';

            $browser->visit('/secret')
            ->assertSee($headerEn)
            ->openSidebar()
            ->click('#sidebar-language-selector')
            ->waitFor('#sidebar-language-es')
            ->click('#sidebar-language-es')
            ->assertSee($headerEs)
            ->openSidebar()
            ->click('#sidebar-language-selector')
            ->waitFor('#sidebar-language-en')
            ->click('#sidebar-language-en')
            ->assertSee($headerEn);
        });
    }
}
