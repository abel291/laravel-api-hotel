@extends('front.layouts.app')

@section('seo_title', 'Reservation')

@section('seo_desc', '')

@section('seo_keys', '')

@section('content')

<div class="text-gray-700 border-b border-gray-200 ">
    @include('front.navbar')
</div>

<div id="container-main" class="container mx-auto max-w-screen-xl section-p-y relative min-h-screen flex items-center justify-center">

    
    <div x-data="reservation_step" class="w-full">
        
        <div class="max-w-xl mx-auto text-red-500 rounded-lg py-4">
            <div class="" x-show="errors.default">
                <span class="block font-bold text-xl" x-text="errors.default"></span>
            </div>
        </div>

        <div x-show="step==1" x-transition.duration.400ms>
            @include('front.reservation.step_1_date')
        </div>

        <div x-show="step==2" x-transition.duration.400ms>
            @include('front.reservation.step_2_rooms')
        </div>

        <div x-show="step==3" x-transition.duration.400ms>
            @include('front.reservation.step_3_complements')
        </div>

        <div x-show="step==4" x-transition.duration.400ms>
            @include('front.reservation.step_4_user')
        </div>

        <div x-show="step==5" x-transition.duration.400ms>
            @include('front.reservation.step_5_order_details')
        </div>


    </div>
</div>
@endsection