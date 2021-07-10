@extends('front.layouts.app')

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)


@section('content')

    <div class=" absolute inset-0 top-0 text-white">
        @include('front.navbar')
    </div>

    @include('front.pieces.banner_title', [
    'title' => $page->title,
    'sub_title' => $page->sub_title,
    'img' => 'img/home/home.jpg'
    ])

    <div class="container mx-auto max-w-screen-xl -mt-20 md:-mt-16 pb-8 border-gray-300 border-b lg:border-none">

        <form class="flex flex-col items-center bg-white 
                                         rounded-t-xl px-5 pt-5 overflow-hidden    space-y-5 
                                         lg:space-y-0 lg:space-x-6 lg:flex-row lg:p-8
                                         lg:rounded-lg lg:shadow-xl   ">
            <div class="grid-cols-1 w-full    gap-8 grid md:grid-cols-3 text-gray-700 ">
                <div>
                    <span class=" tracking-widest block text-sm uppercase mb-1">Entrada:</span>
                    <div class="lg:flex lg:items-center">
                        <input class="w-full p-2 font-bold rounded-md  bg-white border border-gray-300 " type="text"
                            name="start_date" id="start_date">

                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div>
                    <span class=" tracking-widest block text-sm uppercase mb-1">Salida:</span>
                    <div class="flex items-center">

                        <input class="w-full p-2 font-bold rounded-md bg-white border border-gray-300 " type="text"
                            name="end_date" id="end_date">

                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div>
                    <span class=" tracking-widest block text-sm uppercase mb-1">Adultos:</span>
                    <select
                        class="w-full p-2 font-bold  rounded-md focus:outline-none focus:shadow-outline bg-white border border-gray-300 "
                        name="" id="">
                        <option value="">1 Adulto</option>
                        <option value="">2 Adulto</option>
                        <option value="">3 Adulto</option>
                        <option value="">4 Adulto</option>
                        <option value="">5 Adulto</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="text-lg focus:outline-none bg-orange-500 text-white font-bold self-stretch uppercase
                                            text-center rounded-full lg:rounded-md  px-16  py-2 
                                            lg:text-left md:flex-grow">

                <span class="hidden tracking-widest  lg:block text-xs uppercase mb-1">SEGUIR</span>
                <span class="tracking-wider">Reservar</span>
            </button>
        </form>
    </div>

    <div class="container mx-auto max-w-screen-xl section-p-y space-y-8">


        <div class=" md:w-3/4">
            @include('front.pieces.title', [
            'title' => 'Acerca de Nosotros',
            'sub_title' => 'Comienza tu asombrosa Aventura',
            ])
        </div>

        <div class="flex md:flex-row flex-col space-y-5 md:space-y-0 md:space-x-5">
            <p>El clima subtropical húmedo, las altas montañas, la vegetación exótica, las interminables
                playas,
                los parques nacionales, la arquitectura histórica, los atractivos lugares de interés, los
                festivales
                de arte y el animado entorno multicultural hacen de Hotel Cartagena un destino turístico destacado. </p>

            <p>El clima subtropical húmedo, las altas montañas, la vegetación exótica, las interminables
                playas,
                los parques nacionales, la arquitectura histórica, los atractivos lugares de interés, los
                festivales
                de arte y el animado entorno multicultural hacen de Hotel Cartagena un destino turístico destacado. </p>

        </div>

        <div class="flex md:flex-row flex-col space-y-5 md:space-y-0 md:space-x-5">
            <div>
                <img class="rounded-md " src="{{ asset('img/home/img-1.jpg') }}" alt="">
            </div>
            <div>
                <img class="rounded-md " src="{{ asset('img/home/img-2.jpg') }}" alt="">
            </div>
        </div>


    </div>

    <div class="container mx-auto max-w-screen-xl section-p-y space-y-8">

        <div class="flex justify-between">
            <div>
                @include('front.pieces.title', [
                'title' => 'Habitaciones',
                'sub_title' => 'Habitaciones',
                ])
            </div>
            <div class="flex items-end space-x-2 text-gray-700">
                <a class="text-sm md:text-base " href="">Ver toda</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <div class="grid-cols-1 grid md:grid-cols-3 gap-5">

            <a class="w-full md:col-span-2  p-5 bg-cover bg-center rounded-lg"
                style="background-image: linear-gradient(#00000000,#00000040), url(img/home/img-c1.jpg)">

                <div class="flex flex-col h-64 justify-between">
                    <div></div>
                    <div class="text-white leading-tight">
                        <h3 class="font-semibold text-2xl">Modern Room</h3>
                        <p class="text-xl font-light">
                            <span class="text-2xl font-semibold">$99.0</span> noche

                        </p>
                    </div>
                </div>

            </a>

            <a class="w-full p-5 bg-cover bg-center rounded-lg"
                style="background-image: linear-gradient(#00000000,#00000040), url(img/home/img-c2.jpg)">
                <div class="flex flex-col h-64 justify-between">
                    <div></div>
                    <div class="text-white leading-tight">
                        <h3 class="font-semibold text-2xl">Luxe Room</h3>
                        <p class="text-xl font-light">
                            <span class="text-2xl font-semibold">$99.0</span> noche

                        </p>
                    </div>
                </div>
            </a>

            <a class="w-full p-5 bg-cover bg-center rounded-lg"
                style="background-image: linear-gradient(#00000000,#00000040), url(img/home/img-c5.jpg)">
                <div class="flex flex-col h-64 justify-between">
                    <div></div>
                    <div class="text-white leading-tight">
                        <h3 class="font-semibold text-2xl">Apartments</h3>
                        <p class="text-xl font-light">
                            <span class="text-2xl font-semibold">$99.0</span> noche

                        </p>
                    </div>
                </div>
            </a>

            <a class="w-full p-5 bg-cover bg-center rounded-lg"
                style="background-image: linear-gradient(#00000000,#00000040), url(img/home/img-c3.jpg)">
                <div class="flex flex-col h-64 justify-between">
                    <div></div>
                    <div class="text-white leading-tight">
                        <h3 class="font-semibold text-2xl">Grand Delux Room</h3>
                        <p class="text-xl font-light">
                            <span class="text-2xl font-semibold">$99.0</span> noche

                        </p>
                    </div>
                </div>
            </a>

            <a class="w-full p-5 bg-cover bg-center rounded-lg"
                style="background-image: linear-gradient(#00000000,#00000040), url(img/home/img-c4.jpg)">
                <div class="flex flex-col h-64 justify-between">
                    <div></div>
                    <div class="text-white leading-tight">
                        <h3 class="font-semibold text-2xl">Comfort Room</h3>
                        <p class="text-xl font-light">
                            <span class="text-2xl font-semibold">$99.0</span> noche

                        </p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="bg-gray-300 section-p-y">
        <div class="container mx-auto max-w-screen-xl pb-24  lg:pb-20  ">
            <div class="flex flex-col lg:flex-row ">
                <div class="w-full lg:w-2/5 z-10 space-y-8 pb-8 lg:pb-8">
                    <div class="text-center lg:text-left">
                        <span class="sub-title-section">TESTIMONIOS </span>
                        <h2 class="title-section">
                            Que dicen los clientes
                            <span class="text-orange-500">sobre nosotros.</span>
                        </h2>
                    </div>
                    <div class="flex justify-center lg:justify-start">
                        <button id="btn-next" class=" py-4 px-5 bg-white focus:outline-none text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button id="btn-back" class=" py-4 px-5 bg-white focus:outline-none text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                </div>
                <div class="w-full lg:w-3/5 overflow-hidden">
                    <div id="carousel-list">
                        <div class="swiper-wrapper">


                            <div class=" swiper-slide p-8 rounded-md bg-white space-y-5">
                                <h4 class=" text-2xl font-semibold text-gray-700"> Best hotel! </h4>
                                <p class="text-gray-600">
                                    — The hotel has everything you need. On the ground
                                    floor there is a
                                    lobby bar, on the second floor there is a zone with an indoor pool and sauna, on the
                                    seventh floor there
                                    is a restaurant and spa-salon. The rooms are cleaned every day.
                                </p>
                                <div>
                                    <span class="text-gray-700 font-semibold">Jacob Lane from USA</span>
                                </div>
                            </div>

                            <div class="swiper-slide p-8 rounded-md bg-white space-y-5">
                                <h4 class=" text-2xl font-semibold text-gray-700"> Best hotel! </h4>
                                <p class="text-gray-600">
                                    — The hotel has everything you need. On the ground
                                    floor there is a

                                </p>
                                <div>
                                    <span class="text-gray-700 font-semibold">Jacob Lane from USA</span>
                                </div>
                            </div>
                            <div class=" swiper-slide p-8 rounded-md bg-white space-y-5">
                                <h4 class=" text-2xl font-semibold text-gray-700"> Best hotel! </h4>
                                <p class="text-gray-600">
                                    — The hotel has everything you need. On the ground
                                    floor there is a
                                    lobby bar, on the second floor there is a zone with an indoor pool and sauna, on the
                                    seventh floor there
                                    is a restaurant and spa-salon. The rooms are cleaned every day.
                                </p>
                                <div>
                                    <span class="text-gray-700 font-semibold">Jacob Lane from USA</span>
                                </div>
                            </div>

                            <div class="swiper-slide p-8 rounded-md bg-white space-y-5">
                                <h4 class=" text-2xl font-semibold text-gray-700"> Best hotel! </h4>
                                <p class="text-gray-600">
                                    — The hotel has everything you need. On the ground
                                    floor there is a

                                </p>
                                <div>
                                    <span class="text-gray-700 font-semibold">Jacob Lane from USA</span>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container section-p-y  mx-auto max-w-screen-xl text-white  -mt-24 md:-mt-32">

        <div
            class="bg-orange-500 p-8 md:p-12 lg:px-20 lg:py-16 flex flex-col md:flex-row justify-between items-center rounded-md space-y-3 ">
            <div class=" md:w-3/5 space-y-3">

                <h3 class="text-2xl md:text-5xl md:leading-tight font-bold ">Make room for adventure.</h3>
                <p class="font-light">Book your room right now and start your amazing adventure full of discoveries
                    and experiences with Hotel Cartagena.</p>

            </div>
            <div class="w-full md:w-2/5 text-right">
                <a href=""
                    class="px-4 py-2 justify-center  md:px-6 rounded-full bg-white text-orange-500 flex md:inline-flex items-center  space-x-2 ">

                    <span class="font-bold ">Reservacion</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>


            </div>
        </div>
    </div>

    @push('scripts')
        <script defer src="{{ mix('js/flatpickr.js') }}"></script>
        <script defer src="{{ mix('js/swiper.js') }}"></script>
    @endpush
@endsection
