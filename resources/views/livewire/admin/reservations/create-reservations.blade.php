<div>
    <div x-data="{show : false}">


        <x-modal>
            <x-slot name="button">
                <x-jet-button x-on:click="show = true ;">Crear Reservation</x-jet-button>
            </x-slot>
            <x-slot name="title">
                {{-- <h2 class="font-bold text-gray-700">Crear Reservation</h2> --}}
            </x-slot>
            <x-slot name="content">
                <div>
                    <div id="container-main" class="px-4 text-gray-700" x-data="reservation_step">


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

                    </div>
                </div>

            </x-slot>
            <x-slot name="footer">

            </x-slot>
        </x-modal>
    </div>




</div>