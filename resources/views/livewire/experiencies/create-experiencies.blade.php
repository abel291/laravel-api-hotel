<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true ;" wire:click="create">Agregar Experiencia</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Experiencias</h2>
            </x-slot>

            <x-slot name="content">

                <div>
                    <x-jet-label>
                        Nombre de la Experiencia
                        @error('experiencie.name')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3 w-full " type="text" wire:model.defer="experiencie.name">
                    </x-jet-input>

                    <x-jet-label>
                        Url de la habitacion
                        @error('experiencie.slug')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3 w-full sm:w-3/4" type="text" wire:model.defer="experiencie.slug">
                    </x-jet-input>

                    <x-jet-label>
                        Descripcion corta
                        @error('experiencie.description_min')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>

                    <textarea rows="8" class="mb-3 w-full form-input rounded-md shadow-sm"
                        wire:model.defer="experiencie.description_min"></textarea>

                    <x-jet-label>
                        Descripcion Larga
                        @error('experiencie.description_max')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>

                    <textarea rows="8" class="mb-3 w-full form-input rounded-md shadow-sm"
                        wire:model.defer="experiencie.description_max"></textarea>


                    <div class="flex">
                        <div class="mr-4">
                            <x-jet-label>
                                Precio
                                @error('experiencie.price')
                                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>
                            <x-jet-input class="mb-3" type="number" wire:model.defer="experiencie.price"></x-jet-input>
                        </div>
                        <div>
                            <x-jet-label>
                                Tipo de precio
                                @error('experiencie.type_price')
                                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            <div class="">
                                <div class="flex items-center mr-4">
                                    <input id="reservation_price" name="type_price"
                                        wire:model.defer="experiencie.type_price" value="reservation" type="radio"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                      checked>
                                    <label for="reservation_price" class="ml-3 block text-sm font-medium text-gray-700">
                                        por Reservacion
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="nigth_price" name="type_price" wire:model.defer="experiencie.type_price"
                                        value="nigth" type="radio"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        >
                                    <label for="nigth_price" class="ml-3 block text-sm font-medium text-gray-700">
                                        por Noche
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-jet-label>
                        Activo
                        @error('experiencie.type_price')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                        @enderror
                    </x-jet-label>

                    <div class="flex">
                        <div class="flex items-center mr-4">
                            <input id="active_yes" name="active" wire:model.defer="experiencie.active" value="1"
                                type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                {{ $this->experiencie->active ? '' : 'checked' }}>
                            <label for="active_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                Si
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="active_no" name="active" wire:model.defer="experiencie.active" value="0"
                                type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                {{ $this->experiencie->active ? '' : 'checked' }}>
                            <label for="active_no" class="ml-3 block text-sm font-medium text-gray-700">
                                No
                            </label>
                        </div>
                    </div>


                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = false"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <x-jet-label class=" font-bold mb-1">
                            Imagen Miniatura
                            @error('thumbnail')
                                <span class="error text-sm text-red-600 ">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        @include('piece.input-images',[
                        'name' => "thumbnail",
                        'images_temp'=>$this->thumbnail,
                        'images_saved'=>$this->experiencie->thumbnail,
                        'title'=>"Subir imagen",
                        'multiple'=>false,
                        'path'=>'/storage/experiencies/thumbnail/'
                        ])

                    </div>

                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = false"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
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
                        'images_saved'=>$this->experiencie->images,
                        'title'=>"Subir imagen",
                        'multiple'=>true,
                        'path'=>'/storage/experiencies/'
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
                    <x-jet-button class="ml-2" wire:click="update()"
                        wire:loading.attr="disabled">
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
                Borrar Experiencia
            </x-slot>

            <x-slot name="content">
                Esta experiencia no se borrara para reservaciones ya hechas ,sin embargo no estaran disponibles para las
                futuras reservaciones , ¿estas seguro que desea eliminarla?
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show=false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" @click="$wire.delete(id)" wire:loading.attr="disabled">
                    Borrar Experiencia
                </x-jet-danger-button>
            </x-slot>
        </x-modal>
    </div>
</div>
