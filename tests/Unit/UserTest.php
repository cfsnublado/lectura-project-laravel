<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use App\User;
use App\Profile;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if corresponding Profile object is created 
     * when a User object is created.
     *
     * @return void
     */
    public function testProfileCreatedWithUser()
    {
        $this->assertEquals(Profile::count(), 0);

        $user = User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        $user->refresh();

        $this->assertEquals(Profile::count(), 1);

        $profile = Profile::first();
        
        $this->assertEquals($user->profile, $profile);
        $this->assertEquals($profile->user_id, $user->id);
    }
}
