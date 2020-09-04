<?php

namespace Tests\Unit\Resources;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User\User;
use App\Http\Resources\User\User as UserResource;

class UserResourceTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->user = factory(User::class)->create();
        $this->user->refresh();
    }

    /**
     *
     */
    public function testToArray()
    {
        $userResource = new UserResource($this->user);
        $data = $userResource->toArray(request());
        $expectedData = [
            'id' => $this->user->id,
            'username' => $this->user->username,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
        ];
        
        $this->assertEquals($data, $expectedData);
    }
}
