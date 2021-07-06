<div>
    @if ($this->rooms->isNotEmpty())

        
        <div class="mb-4">
            Habitaciones disponibles para <b>{{ $this->reservation->days }} noches </b> desde
            <b>{{ $this->reservation->start_date->isoFormat('DD-MMMM') }}</b> hasta
            <b>{{ $this->reservation->end_date->isoFormat('DD-MMMM') }}</b>
        </div>

        @foreach ($this->rooms as $key => $item)
            <div class="flex justify-between p-3 mb-2 rounded-lg border text-sm border-gray-300" x-data="{                                     
                                    id:'{{ $item->id }}' 
                                }">

                <div class=" w-52">
                    <img src="{{ $item->thumbnailpath }}" alt="">
                </div>
                <div class="flex flex-col flex-grow flex-wrap">
                    <p class=" text-base font-bold">{{ $item->name }} </p>
                    <p>Adultos: {{ $item->adults }} </p>
                    <p><b>${{ $item->price }}</b> por noche</p>
                    
                    @if ($this->reservation->days > 1)
                        <p>
                            <b>${{ number_format($item->total_price_days) }}</b> por
                            {{ $this->reservation->days }}
                            noches
                        </p>
                    @endif

                    <div>
                        <label for="country" class=" text-sm font-medium text-gray-700">Habitaciones
                            a reservar:</label>
                        <select 
                            wire:model.defer="rooms_quantity.{{ $item->id }}" id="n_reserved"
                            class="mt-1 block w-auto max-w py-2 px-6 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm"
                            >

                            @for ($i = 0; $i < $item->quantity_availables; $i++)

                                <option class="p-1" value={{ $i + 1 }}>

                                    {{ $i + 1 }} -
                                    ${{ number_format(($i + 1) * $item->total_price_days ) }}

                                </option>

                            @endfor

                        </select>
                    </div>

                </div>
                <div class="self-end flex flex-col">
                    <x-jet-button wire:click="check_2_room({{ $item->id }})" wire:loading.attr="disabled">
                        Seleccionar
                    </x-jet-button>
                </div>
            </div>
        @endforeach
    @else
        <div class="mb-4 text-center"> NO HAY HABITACIONE DISPONIBLE PARA ESAS FECHAS</div>
    @endif

</div>
