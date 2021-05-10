<div>

    <x-slot name="header">
        {{ __('Complementos') }}
    </x-slot>

    <x-list-data :data="$data">
        <x-slot name="component_create">
            @livewire('complements.create-complements')
        </x-slot>
        <x-slot name="table_th">
            <th scope="col" wire:click="sortBy('id')"
                class=" cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
                @if ($sortBy == 'id' && $sortDirection == 'asc')
                    <span class=" material-icons-outlined">arrow_drop_down</span>
                @elseif($sortBy =='id' && $sortDirection=='desc')
                    <span class=" material-icons-outlined">arrow_drop_up</span>
                @endif
            </th>
            <th scope="col" wire:click="sortBy('name')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nombre
            </th>
            <th scope="col" wire:click="sortBy('email')"
                class=" cursor-pointer px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Icono
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                    {{ $item->id }}
                                </div>

                            </div>
                        </div>
                    </td>
                    <td class=" py-3 ">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm  text-gray-900">
                                    {{ $item->name }}
                                </div>

                            </div>
                        </div>
                    </td>
                    <td>
                        <div class=" text-sm text-gray-500">
                            <img src="{{$item->iconPath}}?{{rand(1,300)}}" class="w-8" alt="{{$item->icon}}">
                        </div>
                    </td>
                    <td class="text-sm font-medium ">
                        <a x-data="{id:{{ $item->id }} }" x-on:click="$dispatch('open-modal-edit',id)"
                            class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</a>

                        <a x-data="{id:{{ $item->id }} }" x-on:click="$dispatch('open-modal-confirmation',id)"
                            class="text-red-600 hover:text-red-900 cursor-pointer">Delete</a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
        </x-list-table>
</div>

