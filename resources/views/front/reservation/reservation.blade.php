@extends('front.layouts.app',[

'nav_type' =>'white',
'banner_type' =>false,
'page_title' =>$page->title,
'page_sub_title' =>$page->sub_title,
'page_img' =>$page->img,
])

@section('seo_title', 'Reservation')

@section('seo_desc', '')

@section('seo_keys', '')

@section('content')


<div x-data="reservation_step" id="container-main"
    class="container mx-auto max-w-screen-xl realtive section-p-y relative min-h-screen">


    <div class="w-full">
        @include('front.reservation.errors-notification')

        <div x-show="step==1" x-transition:enter.duration.400ms>
            @include('front.reservation.step_1_date')
        </div>

        <div x-show="step==2" x-transition:enter.duration.400ms>
            @include('front.reservation.step_2_rooms')
        </div>

        <div x-show="step==3" x-transition:enter.duration.400ms>
            @include('front.reservation.step_3_complements')
        </div>

        <div x-show="step==4" x-transition:enter.duration.400ms>
            @include('front.reservation.step_4_user')
        </div>

        <div x-show="step==5" x-transition.duration.400ms>
            @include('front.reservation.step_5_order_details')
        </div>

    </div>

    <div x-show="isLoading" x-transition:enter class="flex absolute inset-0 blur items-center justify-center" wire:loading.flex >
        <div
            class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-orange-400 ">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span>Processing</span>
        </div>
    </div>

    {{-- <div class="space-x-3 text-right mt-4 max-w-5xl mx-auto">
        <div>
            <button x-show="1<step && step<5" x-on:click="step-=1;scroll_top()"
                class="btn_back_step_reservation ">Volver</button>
        </div>

        <!-- buttons next step -->
        <button class="btn_next_step_reservation" x-show="step==1" x-on:click="step_1_check_date">Chekear disponibilidad
        </button>

        <button class="btn_next_step_reservation" x-show="step==3" x-on:click="step_3_confirmation"> Seguir
        </button>

        <button class="btn_next_step_reservation" x-show="step==4" id="button_stripe"> Finalizar reserva
        </button>

        <button
            class="btn_back_step_reservation"
            x-show="step==5" x-on:click="init">Volver al inicio</button>
        <a x-show="step==5" id='report_pdf_button' target="_blank" href="{{route('reservation.report_pdf')}}" class="btn_next_step_reservation inline-block">
            Ver comprobante
        </a>
    </div> --}}
</div>
@endsection