<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Room;
use App\Models\Blog;
use App\Models\Tag;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

    public function home(){
        $page=Page::where('type','home')->first();
        $rooms=Room::where('active',1)->get()->random(5);
        return view('front.home.home',compact('page','rooms'));
    }
    
    public function about(){
        $page=Page::where('type','about_us')->first();
        
        return view('front.home.about-us',compact('page'));
    }
    
    public function contact(){
        $page=Page::where('type','contact')->first();
        
        return view('front.home.contact',compact('page'));
    }
    
    public function gallery(){
        $page=Page::where('type','gallery')->first();

        $gallery=Gallery::with('images')->where('active',true)->get();

        $images = Image::whereHasMorph(
            'imageable',
            [Gallery::class],
            function (Builder $query) {
                $query->where('active',true);
            }
        )->with('imageable')->get();   

        //dd($gallery->pluck('images')->collapse());

        return view('front.home.gallery',compact('page','images','gallery'));
    }

    public function rooms(){
        $page = Page::where('type','rooms')->first();
        $rooms =  Room::get();
        return view('front.home.rooms',compact('page','rooms'));
    }
    
    public function room($room){
        $room = Room::where('slug',$room)->where('active',1)->first();
        
        return view('front.home.room-selected',compact('room'));
    }

    public function blog(){
        $page = Page::where('type','blog')->first();
        $posts = Blog::where('active',1)->get();  
        $tags = Tag::where('active',1)->get();  
        return view('front.home.blog',compact('page','posts'));
    }

    public function post($slug){
        $page = Page::where('type','blog')->first();
        $post = Blog::where('active',1)->where('slug',$slug)->with('tags')->first();  
        return view('front.home.post',compact('page','post'));
    }

    public function terms_conditions(){
        $page = Page::where('type','terms_conditions')->first();
        
        return view('front.home.terms-conditions',compact('page'));
    }

    public function cancellation_policies(){
        $page = Page::where('type','cancellation_policies')->first();
        
        return view('front.home.cancellation-policies',compact('page'));
    }

    public function privacy_policy(){
        $page = Page::where('type','privacy_policy')->first();
        
        return view('front.home.privacy-policy',compact('page'));
    }
    // public function cancellation_reservation(){
    //     $page = Page::where('type','privacy_policy')->first();
        
    //     return view('front.home.cancellation-reservation',compact('page'));
    // }
    public function cookies_policy(){
        
        
        return view('front.home.cookies-policy',compact('page'));
    }
    public function reservation(Request $request){
        {

            $start_date = $request->start_date ? $request->start_date : Carbon::now()->format('Y-m-d');
    
            $end_date = $request->end_date ? $request->end_date : Carbon::now()->addDay()->format('Y-m-d');
    
            $adults = $request->adults ? $request->adults : 1;
    
            $client = new Client;
            $faker = Faker\Factory::create();
            $client->name = $faker->name;
            $client->phone = $faker->phoneNumber;
            $client->email = $faker->safeEmail;
            $client->country = $faker->country;
            $client->city = $faker->city;
            $client->special_request = $faker->text($maxNbChars = 200);
            
            $page = Page::where('type','reservation')->first();
            return view('front.reservation.reservation', compact('client', 'start_date', 'end_date','adults','page'));
        }
    }
    
}
