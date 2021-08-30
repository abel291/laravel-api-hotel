@extends('front.layouts.app',[
    
    'nav_type'   =>'img',
    'banner_type'   =>'img',
    'page_title'         =>$room->name,
    'page_sub_title'     =>$room->sub_title,
    'page_img'           =>'/storage/rooms/thumbnail/'.$room->thumbnail
])

@section('seo_title', $room->name)

@section('seo_desc', $room->seo_desc)

@section('seo_keys', $room->seo_keys)


@section('content')    

    
    <div class="container mx-auto max-w-screen-xl bg-white rounded-t-2xl -mt-5  md:rounded-none md:mt-0 ">

        <div class="flex flex-wrap  section-p-y space-y-8 lg:space-y-0 ">

            <div class=" w-full lg:w-2/3 space-y-8 lg:pr-4">      

                    <div class="relative">

                        <div class="z-10 absolute top-0 left-0 flex justify-center">
                            <button id="btn-next" class=" py-4 px-5 bg-white focus:outline-none text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button id="btn-back" class=" py-4 px-5 bg-white focus:outline-none text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <div id="carousel-list" class=" overflow-hidden">
                            <div class="swiper-wrapper  ">
                                @foreach ($room->images as $image)
                                    <div class="swiper-slide">
                                        <img class="object-cover w-full" src="{{ $image->image_path }}" alt="about-1">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:divide-x md:divide-gray-300 text-gray-600 font-bold">
                        <div class="flex items-center px-2 md:pr-5 lg:pr-14  py-2 md:py-4 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <span>{{ $room->beds }} Camas</span>
                        </div>
                        <div class="flex items-center px-2 md:px-5 lg:px-14  py-2 md:py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            <span>{{ $room->adults }} Adultos</span>
                        </div>
                        <div class="flex items-center px-2 md:px-5 lg:px-14  py-2 md:py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            <span>{{ $room->kids }} Niños</span>
                        </div>

                    </div>
                    <div class="space-y-2">
                        <h3 class="font-bold text-3xl text-gray-700">Descripción</h3>
                        <div class="text-gray-600">{{ $room->description_max }}</div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="font-bold text-3xl text-gray-700 ">Complementos</h3>
                        <div class="grid grid-cols-6 gap-5">
                            @foreach ($room->complements as $complement)
                                <div class="flex items-center col-span-3 md:col-span-2">
                                    <img class="mr-3" src="{{ $complement->icon_path }}" alt="{{ $complement->name }}">
                                    <div>{{ $complement->name }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="font-bold text-3xl text-gray-700 ">Lista de precios</h3>
                        <div class="grid grid-cols-6 gap-5">
                            @foreach ($room->complements as $complement)
                                <div class="flex items-center col-span-3 md:col-span-2">
                                    <img class="mr-3" src="{{ $complement->icon_path }}" alt="{{ $complement->name }}">
                                    <div>{{ $complement->name }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                
            </div>

            <div class=" w-full lg:w-1/3 space-y-8 ">
                <div>
                    <div class="px-6 py-8 bg-gray-700 text-white">
                        <span class="block text-sm mb-2">PRECIO</span>
                        <div>
                            <span class="font-bold text-3xl">${{ $room->price }}.00</span>
                            <span class="text-lg">/ noche</span>
                        </div>

                    </div>
                    <div class="px-6 py-6 space-y-4 border border-gray-200">
                        <div class="flex items-center text-gray-600 space-x-8 font-semibold">
                            <span>Capacidad: {{ $room->adults }} </span>
                            <span>Niños: {{ $room->kids }}</span>
                        </div>
                        <div class="space-y-3 text-center">
                            <a href="{{route('reservation.index')}}" class="block w-full bg-orange-500 py-3 text-lg text-white rounded-full font-bold">
                                Reservar
                            </a>
                            <div class="text-sm text-gray-400">Consultar la disponibilidad de esta habitación</div>
                        </div>
                    </div>
                </div>
                <div class="px-6">
                    <div class="space-y-6 ">
                        <div class="font-bold text-3xl text-gray-700">Buscar Habitacion</div>

                    </div>
                    <div>
                        <form action="{{route('reservation.index')}}" class="py-4 text-gray-500 flex flex-col space-y-3">

                            <div class="border border-gray-300 rounded-md w-full flex">

                                <div class="w-1/2 py-2 px-4 flex space-x-2 items-center  border-r border-gray-300 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <input id="start_date" class="w-full focus:outline-none capitalize" type="text"
                                        placeholder="Fecha Entrada">
                                </div>

                                <div class="w-1/2 py-2 px-4 flex space-x-2 items-center  ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <input id="end_date" class="w-full focus:outline-none capitalize" type="text"
                                        placeholder="Fecha Salida">
                                </div>

                            </div>

                            <div class="border border-gray-300 rounded-md w-full flex ">
                                <div class=" w-1/2 py-2 px-4 flex space-x-2 items-center  border-r border-gray-300 ">
                                    <label for="adults" class="font-bold text-gray-500">Adultos:</label>

                                    <select class="focus:outline-none w-12 rounded-md " name="adults" id="adults">
                                        <option value="1">1 </option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>

                                <div class=" w-1/2 py-2 px-4 flex space-x-2 items-center ">
                                    <label for="kids" class="font-bold text-gray-500">Niños:</label>

                                    <select class="focus:outline-none w-12 rounded-md border-gray-300" name="kids"
                                        id="kids">
                                        <option value="0">0 </option>
                                        <option value="1">1 </option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>

                            </div>
                            <button
                                class="px-5 py-3 bg-orange-500 rounded-full text-white inline-flex space-x-1 items-center font-bold text-sm tracking-wide  focus:outline-none justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                <span>Chekear Disponibilidad</span>
                            </button>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ mix('js/swiper.js') }}"></script>
        <script src="{{ mix('js/flatpickr.js') }}"></script>
    @endpush
@endsection
