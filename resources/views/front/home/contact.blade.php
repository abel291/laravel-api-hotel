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

    <div class="container mx-auto max-w-screen-lg section-p-y">
        <div class="flex flex-col md:flex-row justify-between">
            <div>
                <h4 class="font-bold text-xl text-gray-800 pb-1">Direccion</h4>
                <p class="text-gray-600 text-sm">23400 S Western Ave, <br> Harbor City, CA 90710</p>
            </div>

            <div>
                <h4 class="font-bold text-xl text-gray-800 pb-1 pt-2 md:pt-0">Contacto</h4>
                <p class="text-gray-600 text-sm">hello@example.com <br> +1 514.123.4567</p>
            </div>

            <div>
                <h4 class="font-bold text-xl text-gray-800 pb-1 pt-2 md:pt-0">Síganos</h4>
                <p class="text-gray-600 text-sm">
                    Connect with me on <a href="">facebook</a>,<br>
                    <a href="">twitter</a> or <a href="">instagram</a>
                </p>
            </div>
        </div>
    </div>

    <div class="section-p-y" style="-webkit-filter: grayscale(100%); filter: grayscale(100%);">
        <iframe class="w-full" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://maps.google.com/maps?q=London%20Eye%2C%20London%2C%20United%20Kingdom&amp;t=m&amp;z=17&amp;output=embed&amp;iwloc=near"
            title="London Eye, London, United Kingdom" aria-label="London Eye, London, United Kingdom"></iframe>
    </div>

    <div class="container mx-auto max-w-screen-md section-p-y  text-center">

        <h4 class="text-2xl md:text-4xl pb-5 font-bold text-gray-800">Solo una forma. Es fácil.</h4>
        <input class="border border-gray-300 p-3 w-full rounded-md mb-3" type="" name="" placeholder="Nombre completo">

        <input class="border border-gray-300 p-3 w-full rounded-md mb-3" type="" name="" placeholder="Email">

        <textarea rows="5" class="border border-gray-300 p-3 w-full rounded-md mb-3" placeholder="Comentario"></textarea>


        <button
            class="px-4 py-2 justify-center  md:px-6 rounded-full text-white bg-orange-500 flex md:inline-flex items-center font-bold">

            Enviar mensaje

        </button>



    </div>
    @push('scripts')


    @endpush
@endsection
