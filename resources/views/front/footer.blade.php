<footer class="border-t border-gray-300  ">

    <div class="container section-p-y mx-auto max-w-screen-xl">

        <div class=" text-gray-700 flex flex-col  justify-between space-y-6 md:space-y-8">

            <div class="flex items-center justify-center space-x-5">

                <img src="{{ asset('/img/facebook-icon.png') }}" alt="facebook">
                <img src="{{ asset('/img/instragam-icon.png') }}" alt="instragam">
                <img src="{{ asset('/img/twt-icon.png') }}" alt="tw">
                <img src="{{ asset('/img/ws-icon.png') }}" alt="ws">

            </div>

            <div
            class="space-y-1 flex flex-col  md:flex-row md:space-x-6 md:space-y-0 md:justify-center text-sm lg:text-base">
            <a href="{{route('terms-conditions')}}">Termino y condiciones</a>
            <a href="{{route('privacy-policy')}}">Politicas de Privacidad</a>
            <a href="{{route('cancellation-policies')}}">Politicas de cancelacion</a>
            {{-- <a href="{{route('cancellation-reservation')}}">Cancelacion de reserva</a> --}}
            <a href="{{route('cookies-policy')}}">Política de Cookies</a>
            {{-- <a href="">Sitemap</a> --}}
        </div>


        <div class="text-center">
            <span class="font-bold">© 2021 Hotel Cartagena</span>

        </div>
    </div>

</div>
</footer>
