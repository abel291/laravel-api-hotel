@extends('front.layouts.app')

@section('seo_title', 'Reservation')

@section('seo_desc', '')

@section('seo_keys', '')

@section('content') 

    <div class="text-gray-700 border-b border-gray-200">
        @include('front.navbar')
    </div>  

    <div class="container mx-auto max-w-screen-xl section-p-y relative">      
        
    </div>
    
    @push('scripts')        
        <script defer src="{{ mix('js/flatpickr.js') }}"></script>
    @endpush
@endsection