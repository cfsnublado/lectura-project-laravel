<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;

class UserApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = User::factory()->create();
    }
    
    /**
     *
     * @return void
     */
    public function testAuthToken()
    {
        $response = $this->post(
            route(
                'api.user.token',
                [
                    'username' => $this->user->username,
                    'password' => 'Pizza?69p'
                ]
            )
        );
        $response->assertStatus(200);
        $data = json_decode($response->getContent());
        $this->assertTrue(property_exists($data, 'token'));
        $this->assertEquals(mb_strlen($data->token, 'utf8'), 43);
    }
}
