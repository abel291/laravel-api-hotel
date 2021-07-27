<div>

    <x-slot name="header">
        {{ __('Codigo de descuento') }}
    </x-slot>



    <x-list-data :data="$data">
        <x-slot name="component_create">
            @livewire('admin.discount.create-discount')
        </x-slot>
        <x-slot name="table_th">
            
            <th scope="col" wire:click="sortBy('code')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Codigo
            </th>
            <th scope="col" wire:click="sortBy('quantity')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Cantidad
            </th>
            <th scope="col" wire:click="sortBy('quantity')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Disponibles - Usados
            </th>
            <th scope="col" wire:click="sortBy('quantity')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Porcentaje
            </th>
            <th scope="col" wire:click="sortBy('active')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Estado
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Opciones
            </th>
        </x-slot>
        <x-slot name="table_td">
            @foreach ($data as $item)
            <tr class="text-sm text-gray-600">
                <td class="p-3 ml-2 font-bold">
                    #{{ $item->code }}
                </td>
                
                <td class="p-3">
                    {{ number_format($item->quantity , 0 ,',','.') }}
                </td>
               
                <td class="p-3">
                    {{ number_format($item->quantity , 0 ,',','.') - $item->reservations_count }} -  {{ $item->reservations_count }}
                </td>
                <td class="p-3 font-semibold">
                    {{ $item->percent }}%
                </td>
                <td>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $item->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $item->active ? 'Activado' : 'Desactivado' }}
                    </span>                
                </td>
                <td class="px-3  text-sm font-medium ">
                    <a x-data="{id:{{ $item->id }} }" x-on:click="$dispatch('open-modal-edit',id)"
                        class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</a>

                    <a x-data="{id:{{ $item->id }} }" x-on:click="$dispatch('open-modal-confirmation',id)"
                        class="text-red-600 hover:text-red-900 cursor-pointer ml-2">Delete</a>
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-list-data>

</div>