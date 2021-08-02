<div x-data="{show : false}">
    <div x-data="reservation_step">
        <x-modal>
            <x-slot name="button">
                <x-jet-button x-on:click="show = true ;">Crear Reservation</x-jet-button>
            </x-slot>
            <x-slot name="title">
                {{-- <h2 class="font-bold text-gray-700">Crear Reservation</h2> --}}
            </x-slot>
            <x-slot name="content">
                <div id="container-main" class="px-4 text-gray-700">

                    @include('livewire.admin.reservations.errors-notification')

                    <div x-show="step==1" x-transition:enter.duration.400ms>
                        <h2 class="text-xl font-bold mb-4">Elija las Fechas</h2>
                        @include('livewire.admin.reservations.step_1_date')
                    </div>

                    <div x-show="step==2" x-transition:enter.duration.400ms>
                        <h2 class="text-xl font-bold mb-4">Elija las Habitaciones</h2>
                        @include('livewire.admin.reservations.step_2_rooms')
                    </div>

                    <div x-show="step==3" x-transition:enter.duration.400ms>
                        <h2 class="text-xl font-bold mb-4">Agregue paquetes adicionale</h2>
                        @include('livewire.admin.reservations.step_3_complements')
                    </div>

                    <div x-show="step==4" x-transition:enter.duration.400ms>
                        @include('livewire.admin.reservations.step_4_user')
                    </div>

                    <div x-show="step==5" x-transition.duration.400ms>
                        <h2 class="text-xl font-bold mb-4">Orden recibida</h2>
                        @include('livewire.admin.reservations.step_5_order_details')
                    </div>

                    <!--laoding -->
                    <div x-show="isLoading" x-transition.opacity
                        class="absolute inset-0 blur flex items-center justify-center">
                        <div
                            class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-gray-600 ">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>Processing</span>
                        </div>
                    </div>


                </div>



            </x-slot>
            <x-slot name="footer">
                <div class="space-x-3">
                    <!-- button back -->
                    <x-jet-secondary-button x-show="1<step && step<5" x-on:click="step-=1;scroll_top()">volver
                    </x-jet-secondary-button>

                    <!-- buttons next step -->
                    <x-jet-button class="right" x-show="step==1" x-on:click="step_1_check_date">Chekear disponibilidad
                    </x-jet-button>

                    <x-jet-button class="right" x-show="step==3" x-on:click="step_3_confirmation"> Seguir
                    </x-jet-button>

                    <x-jet-button class="right" x-show="step==4" id="button_stripe"> Finalizar reserva
                    </x-jet-button>                    
                   
                    <x-jet-secondary-button x-show="step==5" x-on:click="init">Volver al inicio</x-jet-secondary-button>
                    <a x-show="step==5" id='report_pdf_button' target="_blank" href="{{route('reservation.report_pdf')}}">
                        <x-jet-button>Ver comprobante</x-jet-button>
                    </a>
                    
                    
                        


                </div>

            </x-slot>
        </x-modal>

    </div>

    <!-- Details reservaion-->
    {{-- @include('livewire.admin.reservations.details-reservations') --}}

    <!-- delete reservaion-->
    {{-- @include('livewire.admin.reservations.delete-reservations') --}}

</div>