<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppTest extends TestCase
{
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
        $response->assertViewIs('home');
    }

    public function testSessionLocale()
    {
        $response = $this->get('/');
        $response->assertSessionHas('app.locale', 'en');

        $response = $this->get('/en');
        $response->assertSessionHas('app.locale', 'en');

        $response = $this->get('/es');
        $response->assertSessionHas('app.locale', 'es');

        $response = $this->get('/ex');
        $response->assertStatus(404);
    }
}
