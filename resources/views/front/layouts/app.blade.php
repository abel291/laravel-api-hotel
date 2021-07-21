<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> @yield('seo_title','Hotel Cartagena') </title>
    <meta name="description" content=" @yield('seo_desc','Hotel Cartagena') ">
    <meta name="keywords" content=" @yield('seo_keys','Hotel Cartagena') " >
    
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">    
    @stack('styles')
    <script src="https://js.stripe.com/v3/"></script> 
    
</head>

<body class="">
    
    @yield('content')
    
    @include('front.footer')
    
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
    
</body>

</html>