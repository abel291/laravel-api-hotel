<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Complement;
use App\Models\Experience;
use App\Models\Gallery;
use App\Models\Reservation;
use App\Models\Client;

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
       // User::factory(1)->create();
       
        $complements = Complement::factory()->count(3);
        
        $experiences = Experience::factory()->count(3);
        
        Room::factory()->count(10)
        ->hasAttached($complements)
        ->hasAttached($experiences)        
        ->create();      
        
        Client::factory()->count(30)         
        ->has(Reservation::factory()->count(1))        
        ->create();        
        
        Gallery::factory(5)->hasImages(12)->create();       

        
            

        
         
    }
}
