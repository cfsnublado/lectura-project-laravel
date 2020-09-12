<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'id' => '245c0104-6217-4476-a3b6-7f0fcaebd256',
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfs@foo.com',
            'password' => Hash::make('Pizza?69p'),
            'is_superuser' => true,
        ]);
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Foo',
            'username' => 'superfoo',
            'email' => 'superfoo@foo.com',
            'password' => Hash::make('Foox69f'),
            'is_superuser' => true,
        ]);  
        User::create([
            'first_name' => 'Foo',
            'last_name' => 'Foo',
            'username' => 'foo',
            'email' => 'foo@foo.com',
            'password' => Hash::make('Foox69f'),
        ]);  
    }
}
