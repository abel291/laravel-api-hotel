@extends('front.layouts.app',[
    'nav_type'          =>'white',
    'banner_type'       =>false,
    'page_title'         =>$page->title,
    'page_sub_title'     =>$page->sub_title,
    'page_img'           =>$page->img,
])

@section('seo_title', $post->seo_title)

@section('seo_desc', $post->seo_desc)

@section('seo_keys', $post->seo_keys)


@section('content')

    <div class="container mx-auto max-w-screen-xl  ">
        <div class="py-16  md:py-20 lg:py-24 bg-cover bg-center z-0 text-center">
            <span class="sub-title-section md:text-lg md:pb-3">
                ADVENTURE - 
                {{ $post->updated_at->format('F d , Y ') }} - By Admin
            </span>
            <h1 class="title-section">
                {{ $post->title }}
            </h1>

        </div>
        <div>
            <img src="/storage/posts/thumbnail/{{ $post->img }}" alt="{{ $post->title }}" class="w-full">
        </div>
        <div class="md:px-5 section-p-y font-base text-gray-700 leading-relaxed space-y-4 post-content">
            {!!$post->description_max!!}
        </div>
    </div>
    </div>



    @push('scripts')

       

    @endpush
@endsection
