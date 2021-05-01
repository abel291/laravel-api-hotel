<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true ;" wire:click="create">Agregar Habitacion</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Habitacion</h2>
            </x-slot>

            <x-slot name="content">
                <div x-data="{tab:'tab_data'}" @open-modal-edit.window="tab='tab_data'">
                    <nav class="flex mb-4">
                        <a  @click.prevent="tab = 'tab_data'" 
                            :class="{'border-b-2 border-gray-700 text-gray-700 ': tab==='tab_data' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "   
                            href="#"><b>Datos</b></a>

                        <a  @click.prevent="tab = 'tab_image'" 
                            :class="{'border-b-2 border-gray-700 text-gray-700 ': tab==='tab_image' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "  
                            href="#"><b>Imagenes</b></a>

                        <a  @click.prevent="tab = 'tab_experiencie'" 
                            :class="{'border-b-2 border-gray-700 text-gray-700 ': tab==='tab_experiencie' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "    
                            href="#"><b>Complementos</b></a>

                        <a  @click.prevent="tab = 'tab_accessories'" 
                            :class="{'border-b-2 border-gray-700 text-gray-700 ': tab==='tab_accessories' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "    
                            href="#"><b>Experiencias</b></a>


                    </nav>
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="error text-sm text-red-600 block">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div x-show="tab === 'tab_data'">
                        <x-jet-label>
                            Nombre de la habitacion
                            @error('room.name')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-3 w-full sm:w-3/4" type="text" wire:model.defer="room.name">
                        </x-jet-input>

                        <x-jet-label>
                            Url de la habitacion
                            @error('room.slug')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-3 w-full sm:w-3/4" type="text" wire:model.defer="room.slug">
                        </x-jet-input>

                        <x-jet-label>
                            Descripcion corta
                            @error('room.description_min')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <textarea rows="8" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="room.description_min"></textarea>

                        <x-jet-label>
                            Descripcion Larga
                            @error('room.description_max')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <textarea rows="8" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="room.description_max"></textarea>


                        <div class="flex">
                            <div class="mr-4">
                                <x-jet-label>
                                    Precio por noche
                                    @error('room.price')
                                        <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                    @enderror
                                </x-jet-label>
                                <x-jet-input class="mb-3" type="number" wire:model.defer="room.price"></x-jet-input>
                            </div>
                            <div>
                                <x-jet-label>
                                    Cantidad de Habitaciones
                                    @error('room.quantity')
                                        <span class="error text-sm text-red-600  block">{{ $message }}</span>
                                    @enderror
                                </x-jet-label>
                                <x-jet-input class="mb-3" type="number" wire:model.defer="room.quantity"></x-jet-input>
                            </div>
                        </div>
                        <div class="mb-5">

                            <x-jet-label>
                                Activo
                                @error('room.active')
                                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            <div class="flex">
                                <div class="flex items-center mr-4">
                                    <input id="active_yes" name="active" wire:model.defer="room.active" value="1"
                                        type="radio"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        {{ $room->active ? '' : 'checked' }}>
                                    <label for="active_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                        Si
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="active_no" name="active" wire:model.defer="room.active" value="0"
                                        type="radio"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        {{ $room->active ? '' : 'checked' }}>
                                    <label for="active_no" class="ml-3 block text-sm font-medium text-gray-700">
                                        No
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div x-show="tab === 'tab_image'">

                        <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = false"
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
                            'images_temp'=>$thumbnail,
                            'images_saved'=>$room->thumbnail,
                            'title'=>"Subir Imagen Miniatura",
                            'multiple'=>false
                            ])

                        </div>

                        <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = false"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label class=" font-bold mb-1">
                                Galeria de Imagenes
                                @error('images')
                                    <span class="error text-sm text-red-600 ">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            @include('piece.input-images',[
                            'name'=>"images",
                            'images_temp'=>$images,
                            'images_saved'=>$room->images,
                            'title'=>"Subir Galeria de Imagenes",
                            'multiple'=>true
                            ])

                        </div>

                    </div>

                    <div x-show="tab === 'tab_experiencie'">
                    </div>

                    <div x-show="tab === 'tab_accessories'">
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
                    <x-jet-button class="ml-2" wire:click="update({{ $room_id }})" wire:loading.attr="disabled">
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
                Borrar Habitacion
            </x-slot>

            <x-slot name="content">
                ¿Estás seguro de que deseas eliminar este habitacion?
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
