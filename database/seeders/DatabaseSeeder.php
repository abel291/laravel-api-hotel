<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        User::create([
            'name'=>'123123',
            'email'=>'ad@ad.com',
            'phone'=>'123123123',
            'password'=> Hash::make('123123')            
        ]);
         \App\Models\User::factory(100)->create();
         \App\Models\Room::factory(10)->create();
         
    }
}
