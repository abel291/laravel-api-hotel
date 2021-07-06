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
    'img' =>'img/home/about.jpg'
    ])

    <div class="rounded-xl -mt-5 bg-white overflow-x-hidden">

        <div class="container mx-auto max-w-screen-lg space-y-20 md:space-y-28">

            <div>
                <div class=" max-w-md flex flex-col md:flex-row md:items-center justify-between pb-14 ">

                    <div class="">
                        <div class="font-bold mb-1">Got a questions?</div>
                        <div class="text-gray-500">hello@hotelsochi.com</div>
                    </div>
                    <div>
                        <div class="font-bold mb-1">For partners</div>
                        <div class="text-gray-500">partners@hotelsochi.com</div>
                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-between space-y-8 md:space-y-0">
                    <div class="md:w-1/2">
                        @include('front.pieces.title', [
                        'title' => 'NUESTRA HISTORIA',
                        'sub_title' => 'Una breve historia
                        del Hotel Cartagena.',
                        ])
                    </div>

                    <div class="md:w-1/2 flex flex-col space-y-5 md:pl-6 md:pt-8">
                        <p>El clima subtropical húmedo, las altas montañas, la vegetación exótica, las interminables playas,
                            los
                            parques nacionales, la arquitectura histórica, los atractivos lugares de interés, los festivales
                            de arte
                            y el animado entorno multicultural hacen de Sochi un destino turístico destacado.

                        </p>

                        <p>
                            Sochi tiene mucho que ofrecer a los amantes de la naturaleza, los deportes, la historia, el ocio
                            en la
                            playa soleada y las aventuras activas. Hay mucho que hacer y muchas cosas que ver en Sochi, por
                            lo que
                            nunca se aburrirá. </p>

                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="z-10 absolute top-0 left-0 flex justify-center">
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

                <div id="gallery-img" class="">
                    <div class="swiper-wrapper ">

                        <div class="swiper-slide h-96">
                            <img src="{{ asset('img/home/about-1.jpg') }}" alt="about-1">
                        </div>

                        <div class="swiper-slide h-96">
                            <img src="{{ asset('img/home/about-2.jpg') }}" alt="about-2">
                        </div>

                        <div class="swiper-slide h-96">
                            <img src="{{ asset('img/home/about-3.jpg') }}" alt="about-3">
                        </div>

                        <div class="swiper-slide h-96">
                            <img src="{{ asset('img/home/about-4.jpg') }}" alt="about-4">
                        </div>

                        <div class="swiper-slide h-96">
                            <img src="{{ asset('img/home/about-5.jpg') }}" alt="about-5">
                        </div>

                    </div>
                </div>
            </div>

            <div>
                <div class="w-full mb-10 md:mb-15">
                    @include('front.pieces.title', [
                    'title' => 'QUÉ OFRECEMOS',
                    'sub_title' => 'Nuestro enfoque.',
                    ])
                </div>
                <div class=" space-y-10 md:space-y-15">

                    <div class="grid grid-cols-2 gap-x-5">
                        <div class="col-span-2 md:col-span-1 mb-5 md:mb-0">
                            <h3 class="text-3xl md:text-4xl font-bold text-gray-800">Calidad de servicio</h3>
                        </div>
                        <div class="col-span-2 md:col-span-1  text-gray-600 space-y-4 leading-relaxed">
                            <p>
                                La calidad del servicio en la industria hotelera se convierte en uno de los factores más
                                importantes para obtener una ventaja competitiva sostenible y la confianza de los clientes
                                en un
                                mercado altamente competitivo y, por lo tanto, la calidad del servicio puede brindar a la
                                industria hotelera una gran oportunidad de crear una diferenciación competitiva para las
                                organizaciones.</p>
                            <p>
                                Un hotel exitoso ofrece un servicio de excelente calidad a los clientes, y la calidad del
                                servicio se considera la vida del hotel.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-x-5">
                        <div class="col-span-2 md:col-span-1 mb-5 md:mb-0">
                            <h3 class="text-3xl md:text-4xl font-bold text-gray-800">Personal amigable</h3>
                        </div>

                        <div class="col-span-2 md:col-span-1  text-gray-600 space-y-4 leading-relaxed">
                            <p>
                                Los clientes felices son clientes leales. No solo es importante para nosotros brindar un
                                servicio estelar, sino también productos increíbles.

                            </p>
                            <p>
                                El concepto más importante de satisfacción del cliente aceptado en todo el mundo es la
                                teoría de
                                la desconfirmación de expectativas. Esta teoría fue presentada por Oliver, dijo que la etapa
                                de
                                satisfacción es el resultado de la distinción entre actuación anticipada y supuesta.
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-5">
                        <div class="col-span-2 md:col-span-1 mb-5 md:mb-0">
                            <h3 class="text-3xl md:text-4xl font-bold text-gray-800">La satisfacción del cliente</h3>
                        </div>

                        <div class="col-span-2 md:col-span-1  text-gray-600 space-y-4 leading-relaxed">
                            <p>
                                La satisfacción del cliente es un concepto psicológico que involucra la sensación de
                                bienestar y placer que resulta de obtener lo que uno espera y espera de un producto y / o
                                servicio atractivo. La definición de satisfacción del cliente se basa en el punto de vista
                                de la desconfirmación de las expectativas.

                            </p>

                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="w-full mb-10 md:mb-15">
                    @include('front.pieces.title', [
                    'title' => 'CONOCE AL EQUIPO',
                    'sub_title' => 'Personal del hotel.',
                    ])
                </div>
                <div>
                    <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                        <div class="">
                            <div class="rounded-lg bg-center bg-cover h-96"
                                style="background-image:url(img/home/team-1.jpg)">
                            </div>
                            <div class="px-2 py-3">
                                <div class="text-2xl font-bold text-cool-gray-800 mb-1">Robert Fox</div>
                                <div class="text-gray-400 uppercase">CEO, HEAD OF COMMUNITY</div>
                            </div>
                        </div>


                        <div>
                            <div class="rounded-lg bg-center bg-cover h-96"
                                style="background-image:url(img/home/team-2.jpg)">
                            </div>
                            <div class="px-2 py-3">
                                <div class="text-2xl font-bold text-cool-gray-800 mb-1">Kristin Mccoy</div>
                                <div class="text-gray-400 uppercase">CO-FOUNDER & CPO</div>
                            </div>
                        </div>


                        <div>
                            <div class="rounded-lg bg-center bg-cover h-96"
                                style="background-image:url(img/home/team-3.jpg)">
                            </div>
                            <div class="px-2 py-3">
                                <div class="text-2xl font-bold text-cool-gray-800 mb-1">Shane Watson</div>
                                <div class="text-gray-400 uppercase">CHIEF OPERATING OFFICER</div>
                            </div>
                        </div>


                        <div>
                            <div class="rounded-lg bg-center bg-cover h-96"
                                style="background-image:url(img/home/team-4.jpg)">
                            </div>
                            <div class="px-2 py-3">
                                <div class="text-2xl font-bold text-cool-gray-800 mb-1">Francisco Pena</div>
                                <div class="text-gray-400 uppercase">CHIEF FINANCIAL OFFICER</div>
                            </div>
                        </div>


                        <div>
                            <div class="rounded-lg bg-center bg-cover h-96"
                                style="background-image:url(img/home/team-5.jpg)">
                            </div>
                            <div class="px-2 py-3">
                                <div class="text-2xl font-bold text-cool-gray-800 mb-1">Calvin Flore</div>
                                <div class="text-gray-400 uppercase">ASSET MANAGEMENT</div>
                            </div>
                        </div>


                        <div>
                            <div class="rounded-lg bg-center bg-cover h-96"
                                style="background-image:url(img/home/team-6.jpg)">
                            </div>
                            <div class="px-2 py-3">
                                <div class="text-2xl font-bold text-cool-gray-800 mb-1">Kathryn Cooper</div>
                                <div class="text-gray-400 uppercase">ANIMATOR</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mx-auto w-full md:w-3/4 text-center ">
                <div class=" ">
                
                    <div class="text-gray-800 text-5xl md:text-6xl mb-5 font-bold">Haz espacio para la aventura.</div>
                    <div class="text-gray-500 mb-5">Reserve su habitación ahora mismo y comience su increíble
                        aventura llena de descubrimientos y experiencias con Sochi.</div>
                    <div>
                        <a href=""
                            class="px-4 py-2 justify-center  md:px-6 rounded-full text-white bg-orange-500 flex md:inline-flex items-center  space-x-2 ">

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


        </div>


    </div>

    @push('scripts')
        <script src="{{ mix('js/swiper.js') }}"></script>
       
    @endpush
@endsection
