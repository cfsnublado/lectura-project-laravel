<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\User\Profile;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
    }

    /**
     *
     */
    public function testEagerLoad()
    {
        factory(User::class)->create([
            'username' => 'foo'
        ]);
        $user = User::where('username', 'foo')->firstOrFail();
    
        $this->assertTrue($user->relationLoaded('profile'));
    }


    /**
     * Test User uuid value. It should be generated only
     * if not provided in the constructor.
     *
     * @return void
     */
    public function testUuidProvidedInConstructor()
    {
        $uuid = '7e204342-62c6-4b94-b177-f97acd6ec5af';
        $user = factory(User::class)->create(['id' => $uuid]);
        $user->refresh();

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
        $user = factory(User::class)->create(['id' => '']);
        $this->assertTrue(is_string($user->id));
        $this->assertEquals(mb_strlen($user->id, 'utf8'), 36);
    }

    /**
     * Test if User is_superuser default value is false.
     *
     * @return void
     */
    public function testIsSuperuserDefaultFalse()
    {
        $user = factory(User::class)->create();
        $user->refresh();

        $this->assertFalse($user->is_superuser);
    }

    /**
     * Test if User is_superuser returns boolean value.
     *
     * @return void
     */
    public function testIsSuperuserIsBoolean()
    {
        $user = factory(User::class)->create(['is_superuser' => true]);
        $user->refresh();

        $this->assertTrue($user->is_superuser);
    }

    /**
     * Test if corresponding Profile object is created 
     * when a User object is created.
     *
     * @return void
     */
    public function testProfileCreatedWithUser()
    {
        $this->assertEquals(Profile::count(), 0);

        $user = factory(User::class)->create();
        $user->refresh();

        $this->assertEquals(Profile::count(), 1);

        $profile = Profile::first();
        
        $this->assertEquals($user->profile, $profile);
        $this->assertEquals($profile->user_id, $user->id);
    }
}
