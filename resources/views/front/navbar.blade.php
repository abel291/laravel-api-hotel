    <nav x-data="{open:false}"
        :class="{'bg-orange-600 text-white lg:bg-transparent':  open , ' bg-transparent': ! open}">

        <div class="text-lg flex items-center justify-between pl-5  lg:hidden  ">
            <a class="font-bold " href="">Cartagena</a>

            <button class="px-5 py-4 focus:outline-none" x-on:click="open = ! open;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>
        <div :class="{'hidden': ! open}" class="lg:block relative  ">
            <div class="
            w-full px-4 py-5 space-y-4 flex flex-col p-4 text-lg shadow-md justify-between
            lg:flex-row lg:items-center lg:space-y-0 lg:px-10 lg:py-8  lg:bg-transparent lg:shadow-none  
            ">
                <a href="/" class="hidden lg:inline-flex items-center text-2xl font-bold">
                    <div class="leading-none"> Hotel <br> Cartagena</div>
                </a>

                <div class=" font-bold flex  flex-col space-y-1 lg:flex-row lg:items-center">
                    <a href="/" class="  lg:hidden px-3 py-2 rounded-md bg-orange-700 ">Inicio</a>
                    <a href="{{route('rooms')}}"
                        class="px-3 py-2  lg:px-3 rounded-md hover:bg-orange-500 lg:hover:bg-transparent">Habitaciones</a>
                    <a href="{{route('gallery')}}"
                        class="px-3 py-2  lg:px-3 rounded-md  hover:bg-orange-500 lg:hover:bg-transparent">Galleria</a>
                    <a href="{{route('about_us')}}"
                        class="px-3 py-2  lg:px-3 rounded-md  hover:bg-orange-500 lg:hover:bg-transparent">Nosotros</a>
                    <a href="{{route('blog')}}"
                        class="px-3 py-2  lg:px-3 rounded-md  hover:bg-orange-700 lg:hover:bg-transparent">Blog</a>
                    <a href="{{route('contact')}}"
                        class="px-3 py-2  lg:px-3 rounded-md  hover:bg-orange-700 lg:hover:bg-transparent">Contactos</a>
                </div>

                <div class="text-center mt-4">
                    <a href="{{route('reservation.index')}}"
                        class="px-5 py-2 bg-orange-500 rounded-full text-white inline-flex space-x-1 items-center font-bold text-sm tracking-wide  focus:outline-none focus:shadow-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                            <path fill-rule="evenodd"
                                d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                                clip-rule="evenodd " />
                        </svg>
                        <span>Reservacion</span>

                    </a>
                </div>
            </div>
        </div>

    </nav>
