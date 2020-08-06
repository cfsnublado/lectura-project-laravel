<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register the Dusk's browser macros.
     *
     * @return void
     */
    public function boot()
    {
        Browser::macro('openSidebar', function ($element = null) {
            $this->click('#navbar-sidebar-trigger');
            $this->waitFor('#sidebar-language-selector');

            return $this;
        });

        Browser::macro('closeSidebar', function ($element = null) {
            $this->click('#sidebar-trigger');

            return $this;
        });
    }
}