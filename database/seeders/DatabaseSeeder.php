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
use App\Models\Blog;
use App\Models\Page;
use App\Models\Tag;
use Hash;
use Faker as Faker;
use Illuminate\Support\Str;

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
       
        $complements = Complement::factory()->count(5);        
        $experiences = Experience::factory()->count(3);
        
        Room::factory()->count(10)        
        ->hasAttached($complements)        
        ->hasAttached($experiences)        
        ->hasImages(12)
        ->create();      
        
        Client::factory()->count(30)         
        ->has(Reservation::factory()->count(1))        
        ->create();        
        
        Gallery::factory(5)->hasImages(12)->create();       

        $tags = Tag::factory()->count(4);
        
        Blog::factory(13)
        ->hasAttached($tags)
        ->create();  
        
        //Page::factory()->count(4)->create();

        $pages=[
            'home',
            'about_us',
            'gallery',
            'contact',
            'rooms',
            'blog',
            'privacy_policy',
            'cancellation_policies',
            'terms_conditions',
            'reservation',            
        ];
        $faker = Faker\Factory::create();
        foreach ($pages as $key => $value) {
           Page::create([
            'title' => $faker->sentence(4),
            'sub_title' => $faker->sentence(3),
            'description' => $faker->text(400),            
            'slug' => Str::slug($faker->sentence()),
            'img' => 'page-img-'.rand(1,20).'.jpg',              
            'seo_title' => $faker->sentence(),
            'seo_desc' => $faker->sentence(),
            'seo_keys' => $faker->sentence(),
            'type' => $value,
            'lang' => 'es',
           ]);
            
        } 
    } 
} 

