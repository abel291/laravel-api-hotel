<div>
    <div x-data="{
        show : @entangle('open').defer ,
        tab:'tab_data'        
        }" @open-modal-edit.window="
        show = true; 
        $wire.edit($event.detail);
        tab='tab_data'">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true;tab ='tab_data';" wire:click="create">Agregar Post</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Posts</h2>
            </x-slot>

            <x-slot name="content">

                <div>
                    <nav class="flex mb-4">

                        <a @click.prevent="tab = 'tab_data'"
                            :class="{'border-b-2 border-gray-700 text-gray-700  bg-gray-50': tab==='tab_data' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "
                            href="#"><b>Datos</b></a>

                        <a @click.prevent="tab = 'tab_image'"
                            :class="{'border-b-2 border-gray-700 text-gray-700 bg-gray-50 ': tab==='tab_image' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "
                            href="#"><b>Imagen</b></a>

                        <a @click.prevent="tab = 'tab_seo'"
                            :class="{'border-b-2 border-gray-700 text-gray-700 bg-gray-50 ': tab==='tab_seo' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "
                            href="#"><b>SEO</b></a>

                        <a @click.prevent="tab = 'tab_tags'"
                            :class="{'border-b-2 border-gray-700 text-gray-700 bg-gray-50 ': tab==='tab_tags' }"
                            class="p-3 flex justify-center flex-grow border-gray-500 text-gray-500 "
                            href="#"><b>Tags</b></a>

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
                        <h1 class=" font-bold mt-8 mb-5">DATOS PRINCIPALES</h1>
                        <x-jet-label>
                            Titulo
                            @error('post.title')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-4 w-full sm:w-3/4" type="text" wire:model.defer="post.title">
                        </x-jet-input>

                        <x-jet-label>
                            Url de la post
                            @error('post.slug')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-4 w-full sm:w-3/4" type="text" wire:model.defer="post.slug">
                        </x-jet-input>

                        <x-jet-label>
                            Descripcion corta
                            @error('post.description_min')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <textarea rows="8" class="mb-4 w-full form-input rounded-md shadow-sm text-sm"
                            wire:model.defer="post.description_min"></textarea>

                        <x-jet-label>
                            Descripcion Larga
                            @error('post.description_max')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <textarea rows="8" class="mb-4 w-full form-input rounded-md shadow-sm text-sm"
                            wire:model.defer="post.description_max"></textarea>


                        <div class="mb-5">

                            <x-jet-label>
                                Activo
                                @error('post.active')
                                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            <div class="flex">
                                <div class="flex items-center mr-4">
                                    <input id="active_yes" name="active" wire:model.defer="post.active" value="1"
                                        type="radio"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        {{ $post->active ? '' : 'checked' }}>
                                    <label for="active_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                        Si
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="active_no" name="active" wire:model.defer="post.active" value="0"
                                        type="radio"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        {{ $post->active ? '' : 'checked' }}>
                                    <label for="active_no" class="ml-3 block text-sm font-medium text-gray-700">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div x-show="tab === 'tab_image'">
                        <h1 class=" font-bold mt-8 mb-5">IMAGEN</h1>
                        <div class="mt-2" x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = false"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <x-jet-label class=" font-bold mb-1">
                                Imagen Miniatura
                                @error('img')
                                    <span class="error text-sm text-red-600 ">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            @include('piece.input-images',[
                            'name' => "img",
                            'images_temp'=>$img,
                            'images_saved'=>$post->img,
                            'title'=>"Subir Imagen Miniatura",
                            'multiple'=>false,
                            'path'=>'/storage/posts/'
                            ])

                        </div>
                    </div>

                    <div x-show="tab === 'tab_seo'">
                        <h1 class=" font-bold mt-8 mb-5">SEO</h1>
                        <x-jet-label>
                            seo_title
                            @error('post.seo_title')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <textarea rows="3" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="post.seo_title"></textarea>

                        <x-jet-label>
                            seo_des
                            @error('post.seo_desc')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <textarea rows="3" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="post.seo_desc"></textarea>

                        <x-jet-label>
                            seo_keys
                            @error('post.seo_keys')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <textarea rows="3" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="post.seo_keys"></textarea>

                    </div>

                    <div x-show="tab === 'tab_tags'">
                        <h1 class=" font-bold mt-8 mb-5">TAGS</h1>
                        <div class="grid grid-cols-3 gap-1">
                            @foreach (App\Models\Tag::get() as $item)

                                <label>
                                    <input wire:model.defer="tags" value="{{ $item->id }}" type="checkbox"
                                        class="form-checkbox h-5 w-5 text-gray-600">
                                    <span class="ml-2 text-gray-700 ">{{ $item->name }}</span>
                                </label>

                            @endforeach
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
                    <x-jet-button class="ml-2" wire:click="update({{ $post->id }})" wire:loading.attr="disabled">
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
