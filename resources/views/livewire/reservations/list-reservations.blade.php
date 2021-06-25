<div>

    <x-slot name="header">
        {{ __('Reservaciones') }}
    </x-slot>

    <x-list-data :data="$data">
        
        <x-slot name="component_create">
            @livewire('reservations.create-reservations')
        </x-slot>

        <x-slot name="table_th">
            <th scope="col" wire:click="sortBy('id')"
                class=" cursor-pointer pl-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Order
                @if ($sortBy == 'id' && $sortDirection == 'asc')
                    <span class=" material-icons-outlined">arrow_drop_down</span>
                @elseif($sortBy =='id' && $sortDirection=='desc')
                    <span class=" material-icons-outlined">arrow_drop_up</span>
                @endif
            </th>
            <th scope="col" wire:click="sortBy('name')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Reservaciones
            </th>
            <th scope="col" wire:click="sortBy('start_date')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Fechas
            </th>
            <th scope="col" wire:click="sortBy('days')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Dias
            </th>

            <th scope="col" wire:click="sortBy('price')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Precio
            </th>
            <th scope="col" wire:click="sortBy('state')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Estado
            </th>
            <th scope="col" class="pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Opciones
            </th>
        </x-slot>
        <x-slot name="table_td">
            @foreach ($data as $item)
                <tr>
                    <td class=" py-3 ">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm  text-gray-900">
                                    #{{ $item->order }}
                                </div>

                            </div>
                        </div>
                    </td>
                    <td>
                        <div class=" text-sm text-gray-500">
                            {{ $item->client->name }}
                        </div>

                    </td>

                    <td>
                        <div class=" text-sm text-gray-500">
                            {{ $item->start_date->isoFormat('MMMM/DD') }} -
                            {{ $item->end_date->isoFormat('MMMM/DD') }}
                        </div>
                    </td>
                    <td>
                        <div class=" text-sm text-gray-500">
                            {{ $item->days }}
                        </div>
                    </td>
                    <td>
                        <div class=" text-sm text-gray-500">
                            ${{ $item->total_price }}
                        </div>
                    </td>
                    <td>
                        @if ($item->state == 'successful')

                            <div
                                class="px-2 inline-flex items-center space-x-1 text-xs leading-5 font-semibold rounded-lg bg-green-100 text-green-700  ">

                                <span>Aprobada</span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="13" viewBox="0 0 24 24" width="13"
                                    fill="#000000">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                                </svg>
                            </div>

                        @else
                            <div
                                class="px-2 inline-flex items-center space-x-1 text-xs leading-5 font-semibold rounded-lg bg-gray-100 text-gray-700 ">
                                @if ($item->state == 'refunded')
                                    <span> Rembolsada</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="13" viewBox="0 0 24 24" width="13"
                                        fill="#000000">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M19 7v4H5.83l3.58-3.59L8 6l-6 6 6 6 1.41-1.41L5.83 13H21V7h-2z" />
                                    </svg>
                                @endif
                                @if ($item->state == 'canceled')
                                    <span>Cancelada</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="13" viewBox="0 0 24 24" width="13"
                                        fill="#000000">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path
                                            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                                    </svg>
                                @endif
                            </div>

                        @endif





                    </td>
                    <td class="text-sm font-medium ">
                        <a x-data x-on:click="$dispatch('open-modal-details',{{ $item->toJson() }})" 
                            class="text-gray-600 hover:text-gray-900 cursor-pointer mr-2">
                            Ver
                        </a>
                        @if ($item->state == 'successful')

                            <a x-data x-on:click="$dispatch('open-modal-confirmation',{{ $item->toJson() }})" 
                                class="text-red-600 hover:text-red-900 cursor-pointer">

                                Cancelar

                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
        </x-list-table>


</div>
