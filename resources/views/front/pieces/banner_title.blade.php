<div class="w-full min-h-screen bg-cover bg-center text-white flex items-center"
    style="background-image: linear-gradient(#00000000,#00000040),url(/storage/pages/{{$img}})">
    {{-- la img se coloco en un div porque el <img> tenia un fix z-index --}}
    <div class="container mx-auto max-w-screen-xl">
        <div class="md:w-4/5 lg:w-8/12 ">
            <span class="text-base uppercase">{{$sub_title}}</span>

            <h1 class="font-bold text-5xl md:text-6xl leading-tight ">
                {{$title}}
            </h1>
        </div>
    </div>
</div>
