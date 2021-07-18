@extends('front.layouts.app')

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)

@section('content')

    <div class="text-gray-700 border-b border-gray-200">
        @include('front.navbar')
    </div>

    <div class="container mx-auto max-w-screen-xl border-b border-gray-200">
        <form class="py-4 text-gray-500 flex space-y-3 xl:space-y-0 flex-wrap ">

            <div class="w-full xl:w-5/12 xl:pr-4 ">
                <div class="flex flex-wrap  border border-gray-300 rounded-md md:divide-x h-full">
                    <div class="w-full  md:w-1/2 py-2 px-4 inline-flex space-x-2 items-center  ">
                        <div class="flex items-center">
                            <span class="block md:hidden w-20 font-bold">Entrada:</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden md:inline " fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input id="end_date" class="w-32 md:w-full focus:outline-none capitalize bg-transparent "
                            type="text" placeholder="Fecha Entrada">
                    </div>

                    <div class="w-full md:w-1/2  py-2 px-4 inline-flex space-x-2 items-center  ">
                        <div class="flex items-center">
                            <span class="block md:hidden w-20 font-bold">Salida:</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden md:inline " fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input id="start_date" class="w-32 md:w-full focus:outline-none capitalize bg-transparent"
                            type="text" placeholder="Fecha Salida">
                    </div>
                </div>
            </div>



            <div class="w-full md:w-1/2 xl:w-4/12 md:pr-4">
                <div class="flex flex-wrap  border border-gray-300 rounded-md md:divide-x h-full">

                    <div class="w-full  md:w-1/2 py-2 px-4 inline-flex space-x-2 items-center">
                        <span class="font-bold text-gray-500 w-20 md:w-auto">Adultos:</span>

                        <select class="focus:outline-none w-16 rounded-md border-gray-300 bg-transparent " name="adults"
                            id="adults">
                            <option value="1">1 </option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="w-full  md:w-1/2 py-2 px-4 inline-flex space-x-2 items-center">
                        <span class="font-bold text-gray-500 w-20 md:w-auto">Niñoss:</span>

                        <select class="focus:outline-none w-16 rounded-md border-gray-300 bg-transparent " name="adults"
                            id="kids">
                            <option value="1">1 </option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                </div>
            </div>

            <button
                class="w-full md:w-1/2 xl:w-3/12  focus:outline-none text-sm h-full py-3 px-5 bg-orange-500 rounded-full text-white font-bold">
                Chekear Disponibilidad
            </button>



        </form>
    </div>

    @include('front.pieces.banner_title_white', [
    'title' => $page->title,
    'sub_title' => $page->sub_title,
    ])

    <div class="container mx-auto max-w-screen-xl section-p-y">

        <div class="grid grid-cols-6 gap-6">
            @foreach ($rooms as $key => $room)
                <div class="col-span-6 md:col-span-3 lg:col-span-2   ">
                    <div >
                        <a href="/room/{{ $room->slug }}" class="w-full  ">
                            <div class="shadow-md hover:shadow-xl transition-shadow duration-300 ">
                                <div class="relative overflow-hidden">
                                    <img src="/storage/rooms/thumbnail/{{ $room->thumbnail }}"
                                        class="w-full h-64 transition duration-500 transform hover:scale-110 img-list-room">
                                    <div
                                        class="text-white leading-tight space-y-1 py-4 px-4 absolute bottom-0 left-0">
                                        <h3 class="font-semibold text-xl">{{ $room->name }}</h3>
                                        <p class="text-xl font-light">
                                            <span class="text-2xl font-semibold">${{ $room->price }}.00</span>
                                            <span class="text-base">/ noche</span>
                                        </p>
                                    </div>
                                </div>


                                <div class="flex flex-wrap py-6 px-4 text-sm text-gray-600 border-gray-200 md:border-none border justify-between ">
                                    <div class="w-full pb-2 md:pb-0 md:w-1/3 inline-flex items-center space-x-2 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>

                                        <span>{{ $room->beds }} Camas</span>
                                    </div>
                                    <div class="w-1/3 inline-flex items-center space-x-2 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>

                                        <span>{{ $room->adults }} Adultos</span>
                                    </div>
                                    <div class="w-1/3 inline-flex items-center space-x-2 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>

                                        <span>{{ $room->adults }} Niños</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    @push('scripts')
        <script src="{{ mix('js/flatpickr.js') }}"></script>
    @endpush
@endsection
