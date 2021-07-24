@extends('front.layouts.app',[
    'nav_type'   =>'img',
    'banner_type'   =>'img',
    'page_title'         =>$page->title,
    'page_sub_title'     =>$page->sub_title,
    'page_img'           =>$page->img,
])

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)

@section('content')

<div class="container mx-auto max-w-screen-xl -mt-20 md:-mt-16 pb-8 border-gray-300 border-b lg:border-none">

    <form action="{{route('reservation.index')}}" class="flex flex-col items-center bg-white rounded-t-xl px-5 pt-5 overflow-hidden space-y-5 
                                         lg:space-y-0 lg:space-x-6 lg:flex-row lg:p-8
                                         lg:rounded-lg lg:shadow-xl   ">
        <div class="grid-cols-1 w-full    gap-8 grid md:grid-cols-3 text-gray-700 ">
            <div>
                <span class=" tracking-widest block text-sm uppercase mb-1">Entrada:</span>
                <div class="lg:flex lg:items-center">
                    <input class="w-full p-2 font-bold rounded-md  bg-white border border-gray-300 focus:outline-none"
                        type="text" name="start_date" id="start_date">

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

                    <input class="w-full p-2 font-bold rounded-md bg-white border border-gray-300 focus:outline-none"
                        type="text" name="end_date" id="end_date">

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
                    name="adults" id="">
                    <option value="1">1 Adulto</option>
                    <option value="2">2 Adultos</option>
                    <option value="3">3 Adultos</option>
                    <option value="4">4 Adultos</option>
                    <option value="5">5 Adultos</option>
                    <option value="6">6 Adultos</option>
                </select>
            </div>
        </div>

        <button type="submit"
            class="text-lg focus:outline-none bg-orange-500 text-white font-bold self-stretch uppercase text-center rounded-full lg:rounded-md  px-16  py-2 lg:text-left md:flex-grow"
            aria-label="btn_reservar">

            Reservar
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

    <div class="grid-cols-1 grid md:grid-cols-3 gap-5 ">
        @foreach($rooms as $key=>$room)
        <div class="{{$rooms->first()==$room?'md:col-span-2':''}} rounded-lg overflow-hidden "
            style="background-image: linear-gradient(#00000000,#00000040)">

            <a href="{{route('room',$room->slug)}}">
                <div class="relative">
                    <img src="/storage/rooms/thumbnail/{{ $room->thumbnail }}"
                        class="object-cover h-64 w-full transition duration-500 transform hover:scale-110 img-list-room"
                        title="{{$room->name}}-img">

                    <div class="text-white leading-tight space-y-1 py-4 px-4 absolute bottom-0 left-0">
                        <h3 class="font-semibold text-2xl">{{$room->name}}</h3>
                        <p class="text-xl font-light">
                            <span class="text-2xl font-semibold">${{number_format($room->price,2)}}</span> /noche

                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
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
                            <h4 class=" text-2xl font-semibold text-gray-700">¡El mejor hotel! </h4>
                            <p class="text-gray-600">
                                - El hotel tiene todo lo necesario. En la planta baja hay un lobby bar, en el segundo
                                piso hay una zona con piscina interior y sauna, en el séptimo piso hay un restaurante y
                                spa-salón. Las habitaciones se limpian todos los días.
                            </p>
                            <div>
                                <span class="text-gray-700 font-semibold">Jacob Lane from USA</span>
                            </div>
                        </div>

                        <div class="swiper-slide p-8 rounded-md bg-white space-y-5">
                            <h4 class=" text-2xl font-semibold text-gray-700">Hotel confortable. </h4>
                            <p class="text-gray-600">
                                - Bueno, qué puedo decir, cada año, día y hora, este lugar se está transformando para
                                mejor. El personal es completamente competente y amigable, todo a su alrededor está
                                floreciendo, es agradable, nutritivo y hace que las vacaciones sean brillantes.

                            </p>
                            <div>
                                <span class="text-gray-700 font-semibold">Victoria Wilson</span>
                            </div>
                        </div>
                        <div class=" swiper-slide p-8 rounded-md bg-white space-y-5">
                            <h4 class=" text-2xl font-semibold text-gray-700"> El moderno </h4>
                            <p class="text-gray-600">
                                - El moderno Hotel Cartagena de 5 * es una solución ideal para combinar negocios y
                                placer. El diseño elegante y el servicio excepcional satisfarán los deseos de cualquier
                                huésped. 150 habitaciones con balcón (para no fumadores), vista al mar, restaurante de
                                moda.
                            </p>
                            <div>
                                <span class="text-gray-700 font-semibold">Max Edwart</span>
                            </div>
                        </div>

                        <div class=" swiper-slide p-8 rounded-md bg-white space-y-5">
                            <h4 class=" text-2xl font-semibold text-gray-700">¡El mejor hotel! </h4>
                            <p class="text-gray-600">
                                - El hotel tiene todo lo necesario. En la planta baja hay un lobby bar, en el segundo
                                piso hay una zona con piscina interior y sauna, en el séptimo piso hay un restaurante y
                                spa-salón. Las habitaciones se limpian todos los días.
                            </p>
                            <div>
                                <span class="text-gray-700 font-semibold">Jacob Lane from USA</span>
                            </div>
                        </div>

                        <div class="swiper-slide p-8 rounded-md bg-white space-y-5">
                            <h4 class=" text-2xl font-semibold text-gray-700">Hotel confortable. </h4>
                            <p class="text-gray-600">
                                - Bueno, qué puedo decir, cada año, día y hora, este lugar se está transformando para
                                mejor. El personal es completamente competente y amigable, todo a su alrededor está
                                floreciendo, es agradable, nutritivo y hace que las vacaciones sean brillantes.

                            </p>
                            <div>
                                <span class="text-gray-700 font-semibold">Victoria Wilson</span>
                            </div>
                        </div>
                        <div class=" swiper-slide p-8 rounded-md bg-white space-y-5">
                            <h4 class=" text-2xl font-semibold text-gray-700"> El moderno </h4>
                            <p class="text-gray-600">
                                - El moderno Hotel Cartagena de 5 * es una solución ideal para combinar negocios y
                                placer. El diseño elegante y el servicio excepcional satisfarán los deseos de cualquier
                                huésped. 150 habitaciones con balcón (para no fumadores), vista al mar, restaurante de
                                moda.
                            </p>
                            <div>
                                <span class="text-gray-700 font-semibold">Max Edwart</span>
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

            <h3 class="text-2xl md:text-5xl md:leading-tight font-bold ">Haz espacio para la aventura.</h3>
            <p class="font-light">Reserva tu habitación ahora mismo y comienza tu increíble aventura llena de
                descubrimientos. Y experiencias con el Hotel Cartagena.</p>

        </div>
        <div class="w-full md:w-2/5 text-right">
            <a href="{{route('reservation.index')}}"
                class="px-4 py-2 justify-center  md:px-6 rounded-full bg-white text-orange-500 flex md:inline-flex items-center  space-x-2 ">

                <span class="font-bold ">Reservación</span>
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