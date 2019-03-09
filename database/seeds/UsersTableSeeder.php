<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'tarek';
        $user->email = 'tareksh1996.ts@gmail.com';
        $user->password = Hash::make('12345');
        $user->save();
    }
}
