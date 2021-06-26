<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true ;" wire:click="create">Agregar Tags</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Tag</h2>
            </x-slot>

            <x-slot name="content">

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <x-jet-label>
                            Nombre del tag
                            @error('tag.name')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <x-jet-input class="mb-3" type="text" wire:model.defer="tag.name">
                        </x-jet-input>
                    </div>

                    <div>
                        <x-jet-label>
                            Slug
                            @error('tag.slug')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <x-jet-input class="mb-3" type="text" wire:model.defer="tag.slug">
                        </x-jet-input>
                    </div>


                </div>
                <div class="mb-5">

                    <x-jet-label>
                        Activo
                        @error('post.active')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>

                    <div class="flex">
                        <div class="flex items-center mr-4">
                            <input id="active_yes" name="active" wire:model.defer="tag.active" value="1" type="radio"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                {{ $tag->active ? '' : 'checked' }}>
                            <label for="active_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                Si
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="active_no" name="active" wire:model.defer="tag.active" value="0" type="radio"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                {{ $tag->active ? '' : 'checked' }}>
                            <label for="active_no" class="ml-3 block text-sm font-medium text-gray-700">
                                No
                            </label>
                        </div>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show = false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                @if (!$edit_var)
                    <x-jet-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                        Agregar
                    </x-jet-button>
                @else
                    <x-jet-button class="ml-2" wire:click="update({{ $tag->id }})" wire:loading.attr="disabled">
                        Editar
                    </x-jet-button>
                @endif
            </x-slot>
        </x-modal>
    </div>

    <div x-data="{
            show :@entangle('open_modal_confirmation').defer,
            id:''
        }" @open-modal-confirmation.window="show = true;id=$event.detail">

        <x-modal>
            <x-slot name="button"></x-slot>
            <x-slot name="title">
                Borrar tag
            </x-slot>

            <x-slot name="content">
                El tag se borrara para todo los post ¿estas seguro que desea eliminarlo?
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show=false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" @click="$wire.delete(id)" wire:loading.attr="disabled">
                    Borrar Habitacion
                </x-jet-danger-button>
            </x-slot>
        </x-modal>
    </div>
</div>
