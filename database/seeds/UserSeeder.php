<?php

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
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => Hash::make('Pizza?69p'),
            'is_superuser' => true,
        ]);
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Foo',
            'username' => 'superfoo',
            'email' => 'superfoo@foo.com',
            'password' => Hash::make('Pizza?69p'),
            'is_superuser' => true,
        ]);  
    }
}
