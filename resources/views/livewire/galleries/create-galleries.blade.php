<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true ;" wire:click="create">Agregar Categoria</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Categoria</h2>
            </x-slot>

            <x-slot name="content">
                <x-jet-label>
                    Nombre de la Categoria
                    @error('gallery.name')
                        <span class="error text-sm text-red-600 block">{{ $message }}</span>
                    @enderror
                </x-jet-label>
                <x-jet-input class="mb-3 w-full " type="text" wire:model.defer="gallery.name">
                </x-jet-input>

                <div class="flex">
                    <div class="flex items-center mr-4">
                        <input id="active_yes" name="active" wire:model.defer="gallery.active" value="1" type="radio"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                            {{ $this->gallery->active ? '' : 'checked' }}>
                        <label for="active_yes" class="ml-3 block text-sm font-medium text-gray-700">
                            Si
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="active_no" name="active" wire:model.defer="gallery.active" value="0" type="radio"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                            {{ $this->gallery->active ? '' : 'checked' }}>
                        <label for="active_no" class="ml-3 block text-sm font-medium text-gray-700">
                            No
                        </label>
                    </div>
                </div>

                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = false"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-jet-label class=" font-bold mb-1">
                        Imagenes
                        @error('images')
                            <span class="error text-sm text-red-600 ">{{ $message }}</span>
                        @enderror
                    </x-jet-label>

                    @include('piece.input-images',[
                    'name' => "images",
                    'images_temp'=>$this->images,
                    'images_saved'=>$this->gallery->images->sortBy('order'),
                    'title'=>"Subir imagenes",
                    'multiple'=>true,
                    'path'=>'/storage/galleries/'
                    ])

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
                    <x-jet-button class="ml-2" wire:click="update({{ $gallery_id }})" wire:loading.attr="disabled">
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
                Borrar galleryo
            </x-slot>

            <x-slot name="content">
                Este galleryo no se borrara para reservaciones ya hechas ,sin embargo no estaran disponibles para las
                futuras reservaciones , ¿estas seguro que desea eliminarla?
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
    @push('scripts')
        <script src="{{ mix('js/sortable.js') }}" defer></script>
    @endpush   
</div>
