<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=outline -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=round -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Round" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=sharp -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=twotone -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Two+Tone" rel="stylesheet">
    
    @livewireStyles   
    
    
    
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="md:flex flex-col md:flex-row md:min-h-screen w-full">

        <div x-data="{ open: false }"
            class="sidebar-nabvar md:w-64 bg-gray-800 flex-shrink-0 flex-col space-y-1  text-sm text-gray-300  ">

            <div class="max-w-7xl mx-auto px-4 bg-gray-900 h-16">

                <div class="flex  md:justify-center justify-between items-center h-16 ">

                    <div class=" flex  text-2xl font-semibold text-white justify-start  md:justify-center">
                        <a href="!#">
                            RRHH
                        </a>
                    </div>

                    <div class="-mr-2 flex  md:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-100 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>

            </div>
            <div :class="{'block': open, 'hidden': ! open}" class="px-2 py-3 hidden md:block">                
                <x-navbar-item></x-navbar-item>                
            </div>




        </div>
        <div class="w-full">
            @livewire('navigation-dropdown')

            <!-- notification -->
            <x-notification></x-notification>
            <!-- Page Heading -->
            <header class="">

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
                    <h2 class="font-bold text-2xl text-gray-800 ">
                        {{ $header }}
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')
    
    @livewireScripts  
    
    
    <script src="{{ mix('js/app.js') }}" ></script>
    <script src="https://js.stripe.com/v3/"></script>  
    @stack('scripts')
    
</body>

</html>
