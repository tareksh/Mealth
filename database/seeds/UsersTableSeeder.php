<?php

use App\Country;
use App\User;
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
        $user->phone_number = '0932534173';
        $user->country_id =1;
        $user->image = 'C';
        $user->rating =4;
        $user->description = "hi my name is tarek";
        $user->role = "Cooker";
        $user->save();

        $user = new User();
        $user->name = 'bashar';
        $user->email = 'basharsh1996.ts@gmail.com';
        $user->password = Hash::make('12345');
        $user->phone_number = '0932534173';
        $user->country_id =1;
        $user->image = 'C';
        $user->rating =4;
        $user->description = "hi my name is tarek";
        $user->role = "Admin";
        $user->save();


        $user = new User();
        $user->name = 'bashar';
        $user->email = 'basharshCooker1996.ts@gmail.com';
        $user->password = Hash::make('12345');
        $user->phone_number = '0932534173';
        $user->country_id =1;
        $user->image = 'C';
        $user->rating =4;
        $user->description = "hi my name is tarek";
        $user->role = "Cooker";
        $user->save();


        $user = new User();
        $user->name = 'bshr';
        $user->email = 'bshrshCooker1996.ts@gmail.com';
        $user->password = Hash::make('12345');
        $user->phone_number = '0932534173';
        $user->country_id =1;
        $user->image = 'C';
        $user->rating =4;
        $user->description = "hi my name is tarek";
        $user->role = "Admin";
        $user->save();
    }
}
