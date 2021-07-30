<div>

    <div x-data="{ 
        show :false,
        reservation:{},
        client:{},
        room:{},
        discount:{},
        complements:[],
        currencyFormat : '',
        formatNumber(n) {
            n = n ? n : 0;// number NaN = 0
            return '$ ' + this.currencyFormat.format(parseFloat(n))
        },
    }" x-init="
    currencyFormat = Intl.NumberFormat('de-DE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })
    " @open-modal-details.window="
        show = true;
        reservation=$event.detail.reservation;         
        client = $event.detail.client;
        room = $event.detail.room;
        discount = $event.detail.discount;
        if(room.complements_cheked.length){
            complements = Object.values(room.complements_cheked);
        }
        console.log(complements)
        ">

        <x-modal>
            <x-slot name="button"></x-slot>
            <x-slot name="title">
                <h2 class="text-lg mb-4 font-medium">Detalles de reserva # <span x-text="reservation.order"></span>
                </h2>
            </x-slot>

            <x-slot name="content">
                <div class="p-4 text-gray-500 space-y-5">
                    <!--data client-->
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 w-full">

                        <div class="font-bold text-gray-600 col-span-2 text-xl"> Datos de cliente: </div>

                        <div class=""> Invitado: </div>
                        <div>
                            <span x-text="client.name"></span>
                        </div>

                        <div class=""> Email: </div>
                        <div>
                            <span x-text="client.email"></span>
                        </div>

                        <div class=""> Telefono: </div>
                        <div>
                            <span x-text="client.phone"></span>
                        </div>

                        <div class=""> pais: </div>
                        <div>
                            <span x-text="client.country"></span>
                        </div>

                        <div class=""> Ciudad: </div>
                        <div>
                            <span x-text="client.city"></span>
                        </div>

                    </div>

                    <!--data reservation-->
                    <div class=" sm:grid sm:grid-cols-4 sm:gap-2 w-full">

                        <div class="font-bold text-gray-600 col-span-4 text-xl"> Datos de reserva: </div>

                        <div class="col-span-2 "> N° orden: </div>
                        <div class="col-span-2 font-bold">
                            <span x-text=" '#' + reservation.order"></span>
                        </div>

                        <div class="col-span-2 "> Entrada: </div>
                        <div class="col-span-2">
                            <span x-text="reservation.start_date"></span>
                        </div>

                        <div class="col-span-2 "> Salida: </div>
                        <div class="col-span-2">
                            <span x-text="reservation.end_date"></span>
                        </div>

                        <div class="col-span-2 "> Noches: </div>
                        <div class="col-span-2">
                            <span x-text="reservation.night"></span>
                        </div>

                        <div class="col-span-2 ">Habitacion: </div>
                        <div class="col-span-2 font-bold" x-text="room.name"></div>

                        <div class="col-span-2 "> N° de habitaciones: </div>
                        <div class="col-span-2">
                            <span x-text="reservation.room_quantity"></span>
                        </div>
                        <div class="col-span-2 "> Estado: </div>

                        <div class="col-span-2">
                            <div x-show="reservation.state=='successful'">
                                <div
                                    class=" py-1 px-2 bg-green-100 inline-flex items-center text-xm space-x-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold block text-green-700">Pago completado</span>
                                </div>

                            </div>
                            <div x-show="reservation.state=='canceled'">
                                <div
                                    class=" py-1 px-2 bg-gray-100 inline-flex items-center text-xm space-x-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-semibold block text-gray-700">Pago Cancelado</span>
                                </div>
                            </div>
                            <div x-show="reservation.state=='refunded'">
                                <div
                                    class=" py-1 px-2 bg-gray-100 inline-flex items-center text-xm space-x-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 9H10a3 3 0 013 3v1a1 1 0 102 0v-1a5 5 0 00-5-5H8.414l1.293-1.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-semibold block text-gray-700">Pago Rembolsado</span>
                                </div>
                            </div>
                        </div>

                        <div x-show="reservation.state!='successful' " class=" col-span-2 ">
                            Fecha de cancelacion: </div>
                        <div x-show="reservation.state!='successful' " class="col-span-2">
                            <span x-text="reservation.canceled_date"></span>
                        </div>
                    </div>
                    <!--data room - complements - total price -->
                    <table class="w-full text-gray-600">

                        <tr class="font-bold uppercase">
                            <td class="py-2 pr-2 w-1/2 border-b border-gray-200">Producto</td>
                            <td class="w-1/2 border-b border-gray-200">Precio</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="py-2 pr-2  font-semibold"><span x-text="room.name"></span></td>
                            <td><span x-text="formatNumber(room.price)"></span></td>
                        </tr>
                        <template x-for="complement in complements" :key="complement.name">
                            <tr class="border-b border-gray-200">

                                <td class="py-2 pr-2  font-medium">
                                    <span x-text="complement.name" class=""></span>
                                </td>

                                <td>
                                    <span x-text="formatNumber(complement.total_price)"></span>
                                </td>

                            </tr>
                        </template>

                        <tr class="border-b border-gray-200">
                            <td class="py-2 pr-2 font-bold">SUB-TOTAL</td>
                            <td> <span x-text="formatNumber(reservation.sub_total_price)"></span></td>
                        </tr>

                        <tr x-show="discount" class="border-b border-gray-200 ">
                            <td class="py-2 pr-2 font-bold">CUPON NEUTRO</td>
                            <td class="text-green-500" x-text="formatNumber(-discount.amount)"></td>
                        </tr>

                        <tr class="border-b border-gray-200">
                            <td class="py-2 pr-2 font-bold">TOTAL</td>
                            <td class="font-bold text-xl"> <span
                                    x-text="formatNumber(reservation.total_price)"></span> </td>
                        </tr>

                    </table>



















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