@extends('front.layouts.app')

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)

@section('text_color', 'text-gray-800')


@section('content')

    <div class="md:text-gray-800 border-b border-gray-200">    
        @include('front.navbar')
    </div>

    @include('front.pieces.banner_title_white', [
    'title' => $page->title,
    'sub_title' => '',
    ])

    <div class="container mx-auto max-w-screen-lg ">        
        <div>
            <p class="w-full md:w-1/2 text-gray-600">Hotel cartagena tiene mucho que ofrecer a los amantes de la naturaleza, los deportes, la historia, el ocio en la playa soleada y las aventuras activas.</p>
        </div>
    </div>

    <div class="container mx-auto max-w-screen-lg section-p-y">

        <div class="flex flex-col md:flex-row filter-images text-lg pb-4 justify-center text-gray-700 ">
            <button class="img-filter font-bold py-2 px-6 focus:outline-none capitalize" data-filter="*">Todas</button>
            @foreach ($gallery as $item)
            <button class="hover:cursor-pointer img-filter font-bold py-2 px-6 focus:outline-none capitalize" data-filter=".{{$item->slug}}">{{$item->name}}</button>
            @endforeach
            
        </div>
        <div id="gallery-img">
            @foreach ($images->shuffle() as $item)

            <div class="img-item overflow-hidden w-full md:w-2/4 lg:w-1/3 p-2 {{$item->imageable->slug}}">
                <a data-fslightbox href="/storage/galleries/{{$item->image}}">
                    <img src="/storage/galleries/thumbnail/{{$item->image}}" 
                        class="rounded-md w-full" 
                        
                    >
                </a>
            </div>
                
            @endforeach
            
        </div>


    </div>

    
    @push('scripts')
    
        <script src="{{ mix('js/gallery.js') }}"></script>

    @endpush
@endsection
