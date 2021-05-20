<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true ;" wire:click="create">Agregar Complemento</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Complemento</h2>
            </x-slot>

            <x-slot name="content">

                <div>
                    <x-jet-label>
                        Nombre del Complemento
                        @error('complement.name')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3 w-full " type="text" wire:model.defer="complement.name">
                    </x-jet-input>

                    <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = false"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <x-jet-label class=" font-bold mb-1">
                                Icono
                                @error('icon')
                                    <span class="error text-sm text-red-600 ">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            @include('piece.input-images',[
                            'name' => "icon",
                            'images_temp'=>$icon,
                            'images_saved'=>$complement->icon,
                            'title'=>"Subir icono",
                            'multiple'=>false,
                            'path'=>'/storage/complements/'
                            ])

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
                    <x-jet-button class="ml-2" wire:click="update({{ $complement_id }})" wire:loading.attr="disabled">
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
                Borrar complemento
            </x-slot>

            <x-slot name="content">
                Este complemento no se borrara para reservaciones ya hechas ,sin embargo no estaran disponibles para las futuras reservaciones , ¿estas seguro que desea eliminarla? 
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
