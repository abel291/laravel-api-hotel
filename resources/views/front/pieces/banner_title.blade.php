<div class="py-40 md:py-48 lg:py-56 px-4 md:px-12 lg:px-20 bg-cover bg-center z-0 text-white"
        @if($img)
        style="background-image: linear-gradient(#00000000,#00000040), url({{$img}})"
        @endif
        >
        <div class="container mx-auto max-w-screen-lg">
            <div class="md:w-4/5 lg:w-8/12 ">
                @if($title)
                <span class="text-base uppercase">{{$title}}</span>
                @endif
                <h1 class="font-bold text-5xl md:text-6xl leading-tight">
                    {{$sub_title}}
                </h1>
            </div>

        </div>
    </div>