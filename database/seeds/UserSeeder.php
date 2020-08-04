<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::table('users')->insert([
            'first_name' => 'Christopher',
            'last_name' => 'Sanders',
            'username' => 'cfs',
            'email' => 'cfsfoo@foo.com',
            'password' => Hash::make('Pizza?69p'),
        ]);  
    }
}
