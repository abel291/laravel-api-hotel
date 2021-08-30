<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('seo_title','Hotel Cartagena') </title>
    <meta name="description" content=" @yield('seo_desc','Hotel Cartagena') ">
    <meta name="keywords" content=" @yield('seo_keys','Hotel Cartagena') ">

    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    @stack('styles')
    <script src="https://js.stripe.com/v3/"></script>

</head>

<body>

    <div
        class="{{ $nav_type=='img'? 'absolute left-0 right-0 top-0 text-white':'md:text-gray-700 border-b border-gray-200'}} z-10">
        @include('front.navbar')
    </div>

    <div class="min-h-screen z-10">
        
        @if($banner_type)
            @if ($banner_type=='white')

            @include('front.pieces.banner_title_white', [
            'title' => $page_title,
            'sub_title' => $page_sub_title,
            ])

            @else

            @include('front.pieces.banner_title', [
            'title' => $page_title,
            'sub_title' => $page_sub_title,
            'img' =>$page_img
            ])

            @endif
        @endif()

        @yield('content')
    
    </div>

    @include('front.footer')

    <script src="{{ mix('js/app.js') }}"></script>}
    <script src="https://js.stripe.com/v3/"></script>
    @stack('scripts')

</body>

</html>