<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Model\User;
use App\Model\Profile;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test User uuid value. It should be generated only
     * if not provided in the constructor.
     *
     * @return void
     */
    public function testUuidProvidedInConstructor()
    {
        DB::table('users')->delete();

        $uuid = '7e204342-62c6-4b94-b177-f97acd6ec5af';
        $user = User::create([
            'id' => $uuid,
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        $this->assertEquals($user->id, $uuid);
    }

    /**
     * Test if User uuid value generated if it's not provided
     * in the constructor.
     *
     * @return void
     */
    public function testUuidGeneratedOnCreate()
    {
        DB::table('users')->delete();

        $user = User::create([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => 'Pizza?69p',
        ]);
        $this->assertTrue(is_string($user->id));
        $this->assertEquals(mb_strlen($user->id, 'utf8'), 36);
    }

    /**
     * Test if corresponding Profile object is created 
     * when a User object is created.
     *
     * @return void
     */
    public function testProfileCreatedWithUser()
    {
        DB::table('users')->delete();

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
