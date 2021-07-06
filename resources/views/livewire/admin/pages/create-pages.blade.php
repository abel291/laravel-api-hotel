<div>
    <div x-data="{
        show : @entangle('open').defer ,
        tab:'tab_data'        
        }" 
        @open-modal-edit.window="
        show = true; 
        $wire.edit($event.detail);
        tab='tab_data'">

        <x-modal>
            <x-slot name="button">

            </x-slot>

            <x-slot name="title">
                <h2>Paginas {{ $this->page->name }}</h2>
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
                            @error('page.title')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-4 w-full sm:w-3/4" type="text" wire:model.defer="page.title">
                        </x-jet-input>

                        <x-jet-label>
                            Sub titulo
                            @error('page.sub_title')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-4 w-full sm:w-3/4" type="text" wire:model.defer="page.sub_title">
                        </x-jet-input>

                        <x-jet-label>
                            Url de la Pagina
                            @error('page.slug')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <x-jet-input class="mb-4 w-full sm:w-3/4" type="text" wire:model.defer="page.slug">
                        </x-jet-input>

                        <x-jet-label>
                            Descripcion Larga
                            @error('page.description')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>

                        <textarea wire:ignore wire:model.defer="page.description" id="description_ckeditor"
                            wire:key="ckeditor-1" x-data="{
                            description_ckeditor:document.querySelector('#description_ckeditor')
                        }" x-init="
                            $nextTick(() => { 
                                ClassicEditor
                                .create(description_ckeditor)
                                .then(function(editor) {
                                    editor.model.document.on('change:data', () => {
                                        description_ckeditor.value =editor.getData();
                                        description_ckeditor.dispatchEvent(new Event('input'));
                                    })
                                })
                                .catch(error => {
                                    console.error(error);
                                });       
                            })">
                        {!! $this->page->description !!}                
                        </textarea>
                    </div>

                    <div x-show="tab === 'tab_image'">
                        <h1 class=" font-bold mt-8 mb-5">IMAGEN</h1>
                        <div class="mt-2" x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = false"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <x-jet-label class=" font-bold mb-1">
                                Imagen de fondo
                                @error('img')
                                    <span class="error text-sm text-red-600 ">{{ $message }}</span>
                                @enderror
                            </x-jet-label>

                            @include('piece.input-images',[
                            'name' => "img",
                            'images_temp'=>$img,
                            'images_saved'=>$page->img,
                            'title'=>"Subir Imagen de inicio",
                            'multiple'=>false,
                            'path'=>'/storage/pages/'
                            ])

                        </div>
                    </div>

                    <div x-show="tab === 'tab_seo'">
                        <h1 class=" font-bold mt-8 mb-5">SEO</h1>
                        <x-jet-label>
                            seo_title
                            @error('page.seo_title')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <textarea rows="3" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="page.seo_title"></textarea>

                        <x-jet-label>
                            seo_des
                            @error('page.seo_desc')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <textarea rows="3" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="page.seo_desc"></textarea>

                        <x-jet-label>
                            seo_keys
                            @error('page.seo_keys')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <textarea rows="3" class="mb-3 w-full form-input rounded-md shadow-sm"
                            wire:model.defer="page.seo_keys"></textarea>

                    </div>


                </div>






            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show = false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>


                <x-jet-button class="ml-2" wire:click="update({{ $page->id }})" wire:loading.attr="disabled">
                    Editar
                </x-jet-button>

            </x-slot>
        </x-modal>
    </div>

    
</div>
