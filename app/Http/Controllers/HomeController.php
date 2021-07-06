<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

    function index(){
        $page=Page::where('type','home')->first();
        return view('front.home.home',compact('page'));
    }

    function about(){
        $page=Page::where('type','about-us')->first();
        
        return view('front.home.about-us',compact('page'));
    }

    function contact(){
        $page=Page::where('type','contact')->first();
        
        return view('front.home.contact',compact('page'));
    }
    function gallery(){
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
}
