@extends('front.layouts.app',[
    
    'nav_type'   =>'white',
    'banner_type'   =>false,
    'page_title'         =>$page->title,
    'page_sub_title'     =>$page->sub_title,
    'page_img'           =>$page->img,
])

@section('seo_title', 'Reservation')

@section('seo_desc', '')

@section('seo_keys', '')

@section('content')


<div id="container-main" class="container mx-auto max-w-screen-xl section-p-y relative min-h-screen flex items-center justify-center">

    
    <div x-data="reservation_step" class="w-full">
        <div x-show="errors.length" class="max-w-xl mx-auto w-full bg-red-100 rounded-md p-4 flex" x-transition.duration.500ms>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                  </svg>
            </div>
            <div  class="px-4 flex-grow">
                <span class="text-red-700 font-semibold">Tienes Errores por revisar </span>
                <ul class="list-disc text-red-600">
                <template x-for="error in errors">
                    <li x-text="error"></li>    
                </template>
            </ul>
            </div>
            <div>
            <button x-on:click="errors=[]" class="outline-none focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
            </button>
            </div>
        </div>
        
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
</div>
@endsection