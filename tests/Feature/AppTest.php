<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AppTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomeView()
    {
        $response = $this->get(route('app.home'));
        $response->assertStatus(200);
        $response->assertViewIs('app.home');

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('app.home');
    }
}
