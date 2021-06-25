<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Complement;
use App\Models\Experiencie;
use App\Models\Gallery;
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
        User::factory(100)->create();
        
        Room::factory(10)
        ->has(Complement::factory()->count(3))
        ->has(Experiencie::factory()->count(2))
        ->create();
        
        Gallery::factory(5)->hasImages(12)->create();       

        


        
         
    }
}
