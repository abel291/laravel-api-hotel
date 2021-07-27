<div>

    <div x-data="{ 
        show :@entangle('open_modal_confirmation').defer,
        reservation:{},
        room:{},
        client:{},        
    }" @open-modal-confirmation.window="
        show = true;
        reservation = $event.detail;  
        client = reservation.client ;
        room = reservation.room_reservation ;        
        ">

        <x-modal>
            <x-slot name="button"></x-slot>
            <x-slot name="title">
                <h2 class="text-lg mb-4 font-bold">Cancelar reserva </h2>
            </x-slot>

            <x-slot name="content">
                <div class="p-4 text-sm  ">                
                    
                        <div class=" py-1 sm:grid sm:grid-cols-2 sm:gap-1  sm:px-1 w-3/4">
                            
                            <div class="font-medium text-gray-500"> Invitado: </div>
                            <div> 
                                <span x-text=client.name></span> 
                            </div>

                            <div class="font-medium text-gray-500"> Habitacion: </div>
                            <div> 
                                <span x-text=room.name></span> 
                            </div>
                            <div class="font-medium text-gray-500"> Cantidad: </div>
                            <div> 
                                <span x-text=reservation.room_quantity></span> 
                            </div>

                            <div class="font-medium text-gray-500"> Entrada: </div>
                            <div> 
                                <span x-text=reservation.start_date></span> 
                            </div>

                            <div class="font-medium text-gray-500"> Salida: </div>
                            <div> 
                                <span x-text=reservation.end_date></span> 
                            </div>

                            <div class="font-medium text-gray-500"> Noches: </div>
                            <div> 
                                <span x-text=reservation.days></span> 
                            </div>

                            <div class="font-medium text-gray-500">  Precio Total: </div>
                            <div> 
                                <span x-text=" '$'+ reservation.total_price"></span> 
                            </div>                        
                       
                        </div>
                    

                    <p class="mt-7">
                        ¿Estás seguro de que deseas cancelar la reservacion de <span class=" font-bold" x-text=client.name></span>  ?. La habitacion quedara disponible inmediatamente
                        <label class="text-red-600 font-bold mt-4 block">
                            <input class="mr-2 " type="checkbox" wire:model.defer="refund">
                            <span class="text-sm">
                                Rembolsar dinero (<span x-text=reservation.total_price></span>) 
                            </span>
                        </label>
                    </p>
                    @error('refund')
                        <span class="error text-sm text-red-600 block">{{$message}}</span>
                    @enderror

                    
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show=false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" @click="$wire.cancel_reservation(reservation.id)" wire:loading.attr="disabled">
                    Cancelar reservation
                </x-jet-danger-button>
            </x-slot>
        </x-modal>
    </div>

</div>