<div>
    <div class="max-w-4xl mx-auto space-y-5">
        <h2 class="text-4xl font-bold text-gray-700">Confirmacion y Pago</h2>
        
        <div class="space-y-5">
            <h3 class="text-2xl font-bold text-gray-700">Detalles de facturación</h3>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label for="name" class="mb-2 block font-bold text-gray-600 ">
                        Nombre Y Apellido
                        @error('client.name')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="name" type="text" wire:model.defer="client.name">
                </div>
        
                <div>
                    <label for="phone" class="mb-2 block font-bold text-gray-600 ">Telefono
                        @error('client.phone')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="phone" type="text" wire:model.defer="client.phone">
                    
                </div>
                <!---------------------------->
                <div>
                    <label for="email" class="mb-2 block font-bold text-gray-600 ">Email
                        @error('email')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
        
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="email" type="email" wire:model.defer="email">
                    
                </div>
        
                <div>
                    <label for="c_email" class="mb-2 block font-bold text-gray-600 ">
                        Confirmar email
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="c_email" type="email" wire:model.defer="email_confirmation">
                </div>
        
                <div>
                    <label for="country" class="mb-2 block font-bold text-gray-600 ">Pais
                        @error('client.country')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="country" type="text" wire:model.defer="client.country">
                    
                </div>
        
                <div>
                    <label for="city" class="mb-2 block font-bold text-gray-600 ">Ciudad
                        @error('client.city')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
        
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="city" type="text" wire:model.defer="client.city">
                </div>
                <!---------------------------->
                <div x-data
                x-init="
                $nextTick(() => {            
                const check_in = flatpickr($refs.check_in, {                                                               
                        enableTime: true,
                        noCalendar: true,                                        
                        dateFormat: 'G:i K',                                        
                        time_24hr: false,
                        defaultDate:'{{ $this->reservation->check_in }}'
                        
                    });
                });
                    ">
                    <label for="check_in_date" class="mb-2 block font-bold text-gray-600 ">
                        Hora de llegada
                        @error('reservation.check_in')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
        
                    </label>
                    <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" x-ref="check_in" id="check_in_date" type="text" wire:model.defer="reservation.check_in">
                    
                </div>
        
        
                <!---------------------------->
                <div class="special_request col-span-2">
        
                    <label for="special_request" class="mb-2 block font-bold text-gray-600 ">
                        Peticion especial
                        @error('reservation.end_date')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </Label>
        
                    <div class="mt-1">
                        <textarea id="special_request" name="about" rows="3"
                            class="form-input rounded-md mt-1 focus:border-gray-500 block w-full focus:shadow-none  border-gray-300 border-1"
                            placeholder="Algo a tener en cuenta...." wire:model.defer="reservation.special_request"></textarea>
                    </div>
            </div>
        </div>
    </div>
        <div class="space-y-4">
            
            <h2 class="text-2xl font-bold text-gray-700">Tu orden</h2>
            <table class="min-w-full text-gray-700">
                <thead>
                    <tr class="uppercase border-b border-gray-200">
                        
                        <th class="px-4 py-2 text-left font-semibold">Producto</th>
                        <th class="px-4 py-2 text-left font-semibold">Entrada - Salida</th>
                        <th class="px-4 py-2 text-left font-semibold">Total</th>
                    </tr>
                </thead>
                <tr class="border-b border-gray-200">                    
                    <td class="px-4 py-6 text-xl font-bold capitalize">
    
                        <div class="flex items-center space-x-5 ">
    
                            <span x-text=room_selected.name></span>
                        </div>
                    </td>
                    <td class="p-4 ">
                        <span >{{$reservation->start_date}} {{$reservation->end_date}}</span>
                    </td>
                    <td class="p-4 ">
                        <span >{{$total_price_per_reservation}}</span>
                    </td>
                </tr>                
                @foreach ($complements_cheked as $complement)                    
                    <tr class="border-b border-gray-200">
                            
        
                            <td class="pl-10 py-2 pr-4 ">
                                <span class="text-green-500 font-bold"> -Adicioinal- </span>
                                <span >$complement->name</span>
                            </td>
        
                            <td class="px-4 py-2">
                                <span>{{$reservation->start_date}} {{$reservation->end_date}}</span>
                            </td>    

                            <td class="px-4 py-2">
                                <span x-text="formatNumber({{$complement->total_price}})"></span>
                            </td>
        
                    </tr>
                @endforeach                
                
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-6 text-xl font-bold" colspan="2">SUB-TOTAL</td>
                    <td>{{$total_price}}</td>
                </tr>
                
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-6 text-xl font-bold" colspan="2">TOTAL</td>
                    <td class="font-bold">{{$total_price}}</td>
                </tr>

            </table>
        </div>

        <div class="flex space-x-3">
            <div class="">
                <button x-on:click="step=4"
                    class="font-bold w-full py-3 px-14 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-300 focus:outline-none ">Volver</button>
            </div>
            <div class="">
                <button
                    class="font-bold py-3 w-64 rounded-full  text-white bg-orange-500 focus:outline-none "
                    >
                    <span>
                        Confirmar
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>