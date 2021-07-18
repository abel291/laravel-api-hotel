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

    public function index(){
        $page=Page::where('type','home')->first();
        return view('front.home.home',compact('page'));
    }
    
    public function about(){
        $page=Page::where('type','about-us')->first();
        
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

    public function reservation(Request $request){
        //dd($request->all());
        
        
        return view('front.home.reservation');
    }

}
