@extends('front.layouts.app')

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)


@section('content')

    <div class="md:text-gray-700 border-b border-gray-200">    
        @include('front.navbar')
    </div>

    @include('front.pieces.banner_title_white', [
    'title' => $page->title,
    'sub_title' =>  $page->sub_title,
    ])
    

    <div class="container mx-auto max-w-screen-xl section-p-y">
        <div>        
            <div>
                <p class="w-full md:w-3/4 text-gray-600">Hotel cartagena tiene mucho que ofrecer a los amantes de la naturaleza, los deportes, la historia, el ocio en la playa soleada y las aventuras activas.</p>
            </div>
        </div>

        <div class="filter-images  flex flex-col md:flex-row text-lg py-4 text-gray-700 space-x-0 md:space-x-6">
            <button class="img-filter font-bold py-2 focus:outline-none capitalize" data-filter="*">Todas</button>
            @foreach ($gallery as $item)
            <button class="hover:cursor-pointer img-filter font-bold py-2  focus:outline-none capitalize" data-filter=".{{$item->slug}}">{{$item->name}}</button>
            @endforeach
            
        </div>
        <div id="gallery-img" class="-mx-2 -my-1">
            @foreach ($images->shuffle() as $item)

            <div class="img-item  w-full md:w-2/4 lg:w-1/3 p-2 {{$item->imageable->slug}}">
                <div class="overflow-hidden">
                    <a data-fslightbox="{{$item->imageable->slug}}" href="/storage/galleries/{{$item->image}}">
                        <img src="/storage/galleries/thumbnail/{{$item->image}}" 
                            class="rounded-md w-full transition duration-500 transform hover:scale-110" 
                            
                        >
                    </a>
                </div>  
            </div>
                
            @endforeach
            
        </div>


    </div>
    
    @push('scripts')
    
        <script src="{{ mix('js/gallery.js') }}"></script>

    @endpush
@endsection
