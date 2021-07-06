<div>

    <div x-data="{ 
        show :false,
        reservation:{},
        client:{},
        room:{},
        experience:{}
    }" @open-modal-details.window="
        show = true;
        reservation=$event.detail;         
        client = reservation.client;
        room = reservation.room_reservation;
        experience = reservation.experience_reservation;

        ">       

        <x-modal>
            <x-slot name="button"></x-slot>
            <x-slot name="title">
                <h2 class="text-lg mb-4 font-medium">Detalles de reserva # <span x-text="reservation.order"></span> </h2>
            </x-slot>

            <x-slot name="content">
                <div class="p-4 text-sm ">
                                       
                        <div class=" sm:grid sm:grid-cols-6 sm:gap-2 w-full">

                            <div class="font-bold text-gray-600 col-span-6 mb-2"> Datos de reserva: </div>

                            <div class="font-medium text-gray-500 col-span-3 "> N° orden: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.order"></span>
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> Tipo de Habitacion: </div>
                            <div class="col-span-3">
                                <span x-text="room.name"></span>
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> N° de habitaciones: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.room_quantity"></span>
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> Entrada: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.start_date"></span>
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> Salida: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.end_date"></span>
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> Noches: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.days"></span>
                            </div>

                            <div x-show="room.price > 1" class="font-medium text-gray-500 col-span-3 ">Precio por Noches: </div>
                            <div x-show="room.price > 1" class="col-span-3">
                                $<span x-text="reservation.room.price"></span>
                                <span class=" text-xs text-gray-400">por cada habitacion </span>
                            </div>

                            <div x-show="reservation.experience_reservation"
                                class="col-span-6 border-b border-gray-200">
                            </div>

                            <div x-show="reservation.experience_reservation"
                                class="font-medium text-gray-500 col-span-3 ">
                                Experiences: </div>
                            <div x-show="reservation.experience_reservation" class="col-span-3">
                                <span x-text="experience.name"></span>
                            </div>

                            <div x-show="reservation.experience_reservation"
                                class="font-medium text-gray-500 col-span-3 ">
                                Precio: </div>
                            <div x-show="reservation.experience_reservation" class="col-span-3">
                                $<span x-text="experience.price"></span>
                            </div>

                            <div x-show="reservation.experience_reservation"
                                class="col-span-6 border-b border-gray-200">
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> Estado: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.state"></span>
                            </div>

                            <div x-show="reservation.state!='successful' " class="font-medium text-gray-500 col-span-3 ">
                                Fecha de cancelacion: </div>
                            <div x-show="reservation.state!='successful' " class="col-span-3">
                                <span x-text="reservation.canceled_date"></span>
                            </div>

                            <div class="font-medium text-gray-500 col-span-3 "> Precio Total: </div>
                            <div class="col-span-3">
                                <span x-text="reservation.total_price"></span>
                            </div>


                        </div>

                        <div class="sm:grid sm:grid-cols-2 sm:gap-2 w-full mt-8">

                            <div class="font-bold text-gray-600 col-span-2 mb-2"> Datos de cliente: </div>

                            <div class="font-medium text-gray-500"> Invitado: </div>
                            <div >
                                <span x-text="client.name"></span>
                            </div>

                            <div class="font-medium text-gray-500"> Email: </div>
                            <div >
                                <span x-text="client.email"></span>
                            </div>

                            <div class="font-medium text-gray-500"> Telefono: </div>
                            <div >
                                <span x-text="client.phone"></span>
                            </div>

                            <div class="font-medium text-gray-500"> pais: </div>
                            <div >
                                <span x-text="client.country"></span>
                            </div>

                            <div class="font-medium text-gray-500"> Ciudad: </div>
                            <div >
                                <span x-text="client.city"></span>
                            </div>

                        </div>





                   
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show=false" wire:loading.attr="disabled">
                    volver
                </x-jet-secondary-button>
            </x-slot>
        </x-modal>
    </div>

</div>
