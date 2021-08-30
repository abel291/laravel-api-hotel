@extends('front.layouts.app',[
    'nav_type'   =>'white',
    'banner_type'   =>'white',
    'page_title'         =>$page->title,
    'page_sub_title'     =>$page->sub_title,
    'page_img'           =>'/storage/pages/'.$page->img,
])

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)

@section('content')   

    

    <div class="container mx-auto max-w-screen-xl section-p-y">
        <div id="gallery-img" class="-mx-2 -my-1">
            @foreach ($posts as $post)
                <div class="img-item w-full md:w-1/2 p-3">
                    <a href="/blog/post/{{ $post->slug }}" class="">
                        <div class=" shadow-md hover:shadow-xl transition-shadow duration-300  ">
                            <div class="relative overflow-hidden" >
                                <img src="/storage/posts/thumbnail/{{ $post->img }}" 
                                class="w-full transition duration-500 transform hover:scale-110"> 
                                <div class=" text-gray-400 font-bold text-sm bg-white py-4 px-6 absolute bottom-0 left-0 uppercase">
                                    <span class=" text-gray-700">ADVENTURE</span> - {{ $post->updated_at->format('F d , Y ') }}
                                </div>                               
                            </div>
                            <div class="p-6">                                
                                <h3 class="text-gray-700 text-2xl font-bold">{{ $post->title }}</h3>
                            </div>
                        </div>
                    </a>
                </div>

            @endforeach

        </div>
    </div>

    @push('scripts')

        <script src="{{ mix('js/gallery.js') }}"></script>

    @endpush
@endsection
