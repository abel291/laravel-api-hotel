<div>

    <div x-data="{ 
        show :@entangle('open_modal_confirmation').defer,
        refund :@entangle('refund').defer,
    
    }" @open-modal-confirmation.window="show = true;$wire.show($event.detail)">

        <x-modal>
            <x-slot name="button"></x-slot>
            <x-slot name="title">
                <h2 class="text-lg mb-4 font-bold">Cancelar reserva #{{$reservation->order}} </h2>
            </x-slot>

            <x-slot name="content">
                <div class="p-4 space-y-6 text-gray-700 text-sm">

                    <div class=" py-1 sm:grid sm:grid-cols-2 sm:gap-2 sm:px-1">

                        <div class="text-gray-500"> Invitado: </div>
                        <div>
                            {{$client->name}}
                        </div>

                        <div class="text-gray-500"> Entrada: </div>
                        <div>
                            {{$reservation->start_date}}
                        </div>

                        <div class="text-gray-500"> Salida: </div>
                        <div>
                            {{$reservation->end_date}}
                        </div>

                        <div class="text-gray-500"> Habitacion: </div>
                        <div>
                            {{$reservation->room_reservation->name}}
                        </div>
                        <div class="text-gray-500"> Cantidad: </div>
                        <div>
                            {{$reservation->room_quantity}}
                        </div>

                        <div class="text-gray-500"> Noches: </div>
                        <div>
                            {{$reservation->night}}
                        </div>

                        <div class="text-gray-500"> Precio Total: </div>
                        <div class="text-xl font-bold">
                            {{Helpers::format_price($reservation->total_price)}}
                        </div>

                        <div class="flex items-center">
                            <input x-model="refund" x-on:click="refund=!refund" type="checkbox"
                                class="text-red-500 form-checkbox h-5 w-5">
                            <label for="refund_percent" class="font-bold text-red-500 ml-3">Rembolsar</label>
                        </div>
                        <div class="h-10">
                            <select x-show="refund" x-transition class="form-select" id="refund_percent"
                                wire:model.defer="refund_percent"> 
                                @foreach ([10,20,30,40,50,60,70,80,100] as $i)
                                    <option value="{{$i}}">
                                        {{$i}}% - {{Helpers::format_price( $reservation->total_price* ($i/100) )}}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <p class="">
                        ¿Estás seguro de que deseas cancelar la reservacion de <span
                            class=" font-bold">{{$client->name}}</span> ?. La habitacion quedara disponible
                        inmediatamente
                    </p>

                    @error('refund')
                    <span class="error text-sm text-red-600 block">{{$message}}</span>
                    @enderror

                    @error('refund_percent')
                    <span class="error text-sm text-red-600 block">{{$message}}</span>
                    @enderror



                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button x-on:click="show=false;refund=false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="cancel_reservation({{ $reservation->id }})"
                    wire:loading.attr="disabled">
                    Cancelar reservation
                </x-jet-danger-button>
            </x-slot>
        </x-modal>
    </div>

</div>