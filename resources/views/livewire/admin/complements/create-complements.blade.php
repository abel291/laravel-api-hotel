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
                    <div>
                        <x-jet-label>
                            Nombre del Complemento
                            @error('complement.name')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <x-jet-input class="mb-3 w-full md:w-1/2 " type="text" wire:model.defer="complement.name">
                        </x-jet-input>
                    </div>

                    <!-- input precio -->
                    <div class=" flex space-x-2">
                        <div class="w-full md:w-40">
                            <x-jet-label>
                                Precio
                                @error('complement.price')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>
                            <x-form.input-price wire:model.defer="complement.price"></x-form.input-price>
                        </div>
                        <div class="w-full md:w-40">
                            <x-jet-label>
                                Tipo de precio
                                @error('complement.type_price')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            <select class="rounded-md mt-1 block   sm:text-sm border border-gray-300 form-select"
                                wire:model.defer="complement.type_price">
                                <option value="night">por noche</option>
                                <option value="reservation">por reservation</option>
                                <option value="free">gratis</option>
                            </select>
                        </div>
                        <div class="w-full md:w-40">
                            <x-jet-label>
                                Activo
                                @error('complement.active')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>
                            <x-form.input-active wire:model.defer="complement.active"></x-form.input-active>
                        </div>
                    </div>

                    <!-- input description min -->
                    <div>
                        <x-jet-label>
                            Descripcion corta
                            @error('complement.description_min')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <textarea wire:model.defer="complement.description_min" rows="4"
                            class="mt-1 w-full form-textarea rounded-md shadow-sm text-sm mb-3"></textarea>
                    </div>

                    <!-- input imagen -->
                    <div class="mb-3" x-data="{ isUploading: false, progress: 0 }"
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
                Este complemento no se borrara para reservaciones ya hechas ,sin embargo no estaran disponibles para las
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
</div>