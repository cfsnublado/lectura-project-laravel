<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class ProjectsPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/blog/projects';
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
            '@project' => '.project-box',
            '@projectDeleteYes' => '#project-delete-ok',
        ];
    }

    /**
     * Wait for project boxes to load after ajax call.
     *
     */
    public function waitForProjects(Browser $browser)
    {
        $browser->waitFor('@project');
    }

    public function checkNoProject(Browser $browser, $id)
    {
        $browser->assertMissing('#project-delete-' . $id);
    }

    /**
     *
     */
    public function deleteProjectAjax(Browser $browser, $id)
    {
        $projectBox = '#project-delete-' . $id;
        $browser->click($projectBox)
        ->waitFor('@projectDeleteYes')
        ->click('@projectDeleteYes')
        ->waitUntilMissing($projectBox);
    }
}
