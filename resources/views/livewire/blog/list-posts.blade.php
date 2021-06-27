<div>

    <x-slot name="header">
        {{ __('Blog') }}
    </x-slot>

    <x-list-data :data="$data">

        <x-slot name="component_create">
            @livewire('blog.create-posts')
        </x-slot>

        <x-slot name="table_th">
            <th scope="col" wire:click="sortBy('id')"
                class=" cursor-pointer pl-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                id
                @if ($sortBy == 'id' && $sortDirection == 'asc')
                    <span class=" material-icons-outlined">arrow_drop_down</span>
                @elseif($sortBy =='id' && $sortDirection=='desc')
                    <span class=" material-icons-outlined">arrow_drop_up</span>
                @endif
            </th>

            <th scope="col" wire:click="sortBy('title')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Titulo
            </th>

            <th scope="col" wire:click="sortBy('active')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Activo
            </th>
            <th scope="col" wire:click="sortBy('created_at')"
                class=" cursor-pointer pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Fechas de creacion
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
                                    {{ $item->id }}
                                </div>

                            </div>
                        </div>
                    </td>

                    <td>
                        <div class=" text-sm text-gray-500">
                            {{ $item->title }}

                        </div>
                    </td>


                    <td>
                        <div class=" text-sm text-gray-500 text-center">
                            <div class="px-2 py-1 inline-block text-sm font-semibold rounded-full
                            {{ $item->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} 
                            ">
                                <span>{{ $item->active ? 'si' : 'no' }}</span>
                            </div>
                        </div>

                    </td>
                    <td>
                        <div class=" text-sm text-gray-500">
                            {{ $item->created_at }}

                        </div>
                    </td>
                    <td class="text-sm font-medium space-x-2 p-2">
                        <a x-data="{id:{{ $item->id }} }" x-on:click="$dispatch('open-modal-edit',id)"
                            class="text-indigo-600 hover:text-indigo-900 cursor-pointer">
                            Editar
                        </a>


                        <a x-data="{id:{{ $item->id }} }" x-on:click="$dispatch('open-modal-confirmation',id)"
                            class="text-red-600 hover:text-red-900 cursor-pointer">
                            Eliminar
                        </a>

                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-list-data>
    @push('scripts')
        <script src="{{ mix('js/ckeditor.js') }}"></script>
        
    @endpush

</div>
