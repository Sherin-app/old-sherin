<?php

use App\Models\User;
use Illuminate\Database\Seeder;
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
        return User::create([
            'is_admin'=>1,
            'firstname'=>'sherin',
            'lastname'=>'admin',
            'phone'=>'212675295551',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('123456'),
        ]);
    }
}
