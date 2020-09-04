<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AppControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * Test home view.
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->get(route('app.home'));
        $response->assertStatus(200);
        $response->assertViewIs('app.home');

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('app.home');
    }
}
