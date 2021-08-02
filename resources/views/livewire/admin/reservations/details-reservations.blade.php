<div>

    <div x-data="{show:false}" @open-modal-details.window="show = true;$wire.show($event.detail)">

        <x-modal>
            <x-slot name="button"></x-slot>
            <x-slot name="title">
                <h2 class="text-lg mb-4 text-gray-600 font-semibold">Detalles de reserva
                    <b>#{{$reservation->order}}</b></span>
                </h2>
            </x-slot>

            <x-slot name="content">
                <div class="p-4 text-gray-600 space-y-5 text-sm">
                    <!--data client-->
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 w-full">

                        <div class="font-bold text-gray-600 col-span-2 text-base"> Datos de cliente: </div>

                        <div class=""> Invitado: </div>
                        <div>
                            <span>{{$client->name}}</span>
                        </div>

                        <div class=""> Email: </div>
                        <div>
                            <span>{{$client->email}}</span>
                        </div>

                        <div class=""> Telefono: </div>
                        <div>
                            <span>{{$client->phone}}</span>
                        </div>

                        <div class=""> pais: </div>
                        <div>
                            <span>{{$client->country}}</span>
                        </div>

                        <div class=""> Ciudad: </div>
                        <div>
                            <span>{{$client->city}}</span>
                        </div>

                    </div>

                    <!--data reservation-->
                    <div class=" sm:grid sm:grid-cols-4 sm:gap-2 w-full">

                        <div class="font-bold text-gray-600 col-span-4 text-base"> Datos de reserva: </div>

                        <div class="col-span-2 "> N° orden: </div>
                        <div class="col-span-2 font-bold">
                            <span>#{{$reservation->order}}</span>
                        </div>

                        <div class="col-span-2 "> Entrada: </div>
                        <div class="col-span-2">
                            <span>{{$reservation->start_date}}</span>
                        </div>

                        <div class="col-span-2 "> Salida: </div>
                        <div class="col-span-2">
                            <span>{{$reservation->end_date}}</span>
                        </div>

                        <div class="col-span-2 "> Noches: </div>
                        <div class="col-span-2">
                            <span>{{$reservation->night}}</span>
                        </div>

                        <div class="col-span-2 ">Habitacion: </div>
                        <div class="col-span-2 font-bold">{{$reservation->room_reservation->name}}</div>

                        <div class="col-span-2 "> N° de habitaciones: </div>
                        <div class="col-span-2">
                            <span>{{$reservation->room_quantity}}</span>
                        </div>
                        <div class="col-span-2 "> Estado: </div>

                        <div class="col-span-2 text-sm">
                            @if ($reservation->state=='successful')
                            <div class="inline-flex items-center text-sm space-x-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold block text-green-700">Pago completado</span>
                            </div>
                            @elseif($reservation->state=='canceled')


                            <div class="inline-flex items-center text-sm space-x-1 rounded-md text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold block ">Pago Cancelado</span>
                            </div>

                            @elseif($reservation->state=='refunded')

                            <div class="inline-flex items-center text-sm space-x-1 rounded-md text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 9H10a3 3 0 013 3v1a1 1 0 102 0v-1a5 5 0 00-5-5H8.414l1.293-1.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold block ">Pago Rembolsado</span>
                            </div>

                            @endif
                        </div>
                        @if (($reservation->state!='successful'))
                        <div class=" col-span-2 ">
                            Fecha de cancelacion: </div>
                        <div class="col-span-2">
                            <span>{{$reservation->canceled_date}}</span>
                        </div>
                        @endif

                    </div>
                    <!--data room - complements - total price -->
                    <table class="w-full text-gray-600">
                        <tr class="font-bold uppercase">
                            <td class="py-2 pr-2 w-1/2 border-b border-gray-200">Producto</td>
                            <td class="w-1/2 border-b border-gray-200">Precio</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="py-2 pr-2  font-semibold">{{$reservation->room_reservation->name}}</td>
                            <td>{{Helpers::format_price($reservation->room_reservation->price)}}</td>
                        </tr>
                        @if ($reservation->room_reservation->complements_cheked)
                            @foreach ($reservation->room_reservation->complements_cheked as $complement)
                                <tr class="border-b border-gray-200">

                                <td class="py-2 pl-4 font-medium">{{$complement->name}}</td>

                                <td>
                                    {{Helpers::format_price($complement->total_price)}}
                                </td>

                            </tr>
                            @endforeach                        
                        @endif
                        <tr class="border-b border-gray-200">
                            <td class="py-2 pr-2 font-bold">SUB-TOTAL</td>
                            <td>{{Helpers::format_price($reservation->sub_total_price)}}</td>
                        </tr>
                        @if ($reservation->discount_reservation)
                        <tr class="border-b border-gray-200 ">
                            <td class="py-2 pr-2 font-bold up">CUPON DESCUENTO</td>
                            <td class="text-green-500">{{Helpers::format_price(-$reservation->discount_reservation->amount)}}</td>
                        </tr>
                        @endif                        

                        <tr class="border-b border-gray-200">
                            <td class="py-2 pr-2 font-bold">TOTAL</td>
                            <td class="font-bold text-base">{{Helpers::format_price($reservation->total_price)}}</td>
                        </tr>

                    </table>

                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
                    volver
                </x-jet-secondary-button>
            </x-slot>
        </x-modal>
    </div>

</div>