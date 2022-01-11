<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogTagResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ImagesResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\RoomResource;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Page;
use App\Models\Room;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function init()
    {
        $pages = Page::get()->keyBy('type');

        $rooms = Room::where('active', 1)->with(['complements' =>  function ($query) {
            $query->where('active', true);
        }])->with('images:id,image,order,imageable_id')->get();

        return response()->json([

            'pages' => PageResource::collection($pages),
            'rooms' => RoomResource::collection($rooms)
        ]);
    }



    public function home()
    {
        $page = Page::where('type', 'home')->firstOrFail();
        $rooms = Room::where('active', 1)->get()->random(5);
        return [
            'page' => new PageResource($page),
            'rooms' => RoomResource::collection($rooms)
        ];
    }
    public function rooms()
    {   
        
        $page = Page::where('type', 'rooms')->firstOrFail();
        $rooms =  Room::where('active', true)->get();
        return [
            'page' => new PageResource($page),
            'rooms' => RoomResource::collection($rooms)
        ];
    }

    public function room($slug)
    {
        $room = Room::where('slug', $slug)->where('active', 1)->with('complements','images')->first();
        return [
            'room' => new RoomResource($room),
        ];
    }

    public function about_us()
    {
        $page = Page::where('type', 'about_us')->firstOrFail();
        return [
            'page' => new PageResource($page),
        ];
    }

    public function contact()
    {
        $page = Page::where('type', 'contact')->first();

        return [
            'page' => new PageResource($page),
        ];
    }
    public function blog()
    {
        $page = Page::where('type', 'blog')->first();
        $tags = Tag::where('active', 1)->get();

        return response()->json([
            'page' => new PageResource($page),
            'tags' => BlogTagResource::collection($tags)
        ]);
    }
    public function posts()
    {
        $posts = Blog::where('active', 1)->paginate(10);
        return response()->json($posts);
    }
    public function post($slug)
    {

        $post = Blog::where('active', 1)->where('slug', $slug)->with('tags')->firstOrFail();
        setlocale(LC_ALL, 'es');
        return response()->json([
            'post' => new BlogResource($post),
        ]);
    }

    public function gallery()
    {

        $page = Page::where('type', 'gallery')->first();

        $galleries = Gallery::where('active', true)->get();

        $images = Image::whereHasMorph(
            'imageable',
            [Gallery::class],
            function (Builder $query) {
                $query->where('active', true);
            }
        )->with('imageable')->get()->shuffle();

        return response()->json([
            'galleries' => GalleryResource::collection($galleries),
            'images' => ImageResource::collection($images),
            'page' => new PageResource($page),
        ]);
    }





    // public function post($slug)
    // {
    //     $page = Page::where('type', 'blog')->first();
    //     $post = Blog::where('active', 1)->where('slug', $slug)->with('tags')->first();
    //     return view('front.home.post', compact('page', 'post'));
    // }

    public function terms_conditions()
    {
        $page = Page::where('type', 'terms_conditions')->first();

        return [
            'page' => new PageResource($page),
        ];
    }
    public function privacy_policy()
    {
        $page = Page::where('type', 'privacy_policy')->first();

        return [
            'page' => new PageResource($page),
        ];
    }

    public function cookies_policy()
    {
        $page = Page::where('type', 'cookies_policy')->first();
        return [
            'page' => new PageResource($page),
        ];
    }

    public function cancellation_policies()
    {
        $page = Page::where('type', 'cancellation_policies')->first();

        return [
            'page' => new PageResource($page),
        ];
    }
    
    // public function cancellation_reservation()
    // {
    //     $page = Page::where('type', 'cancellation_reservation')->first();
    //     return [
    //         'page' => new PageResource($page),
    //     ];
    // }
    
}
