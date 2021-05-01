<div>
    <label for="{{ $name }}" wire:loading.class="bg-gray-500 cursor-auto"
        wire:loading.class.remove="bg-gray-800 cursor-pointer" wire:target="{{ $name }}"
        class=" inline-block  mb-4 cursor-pointer  px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
        <span wire:loading.class="hidden" wire:target="{{ $name }}">{{ $title }}</span>
        <span wire:loading wire:target="{{ $name }}" x-text=" 'Subiendo ' + progress + '%' "></span>

        <input wire:target="{{ $name }}" wire:loading.attr="disabled" id="{{ $name }}" type="file"
            class="sr-only" wire:model="{{ $name }}" accept=".png, .jpg, .jpeg"
            {{ $multiple ? 'multiple' : '' }}>
    </label>

    <div class=" mt-1 mb-8" wire:loading.class="hidden" wire:target="{{ $name }}">
        @if ($images_temp)
            @if (is_array($images_temp))
                @foreach ($images_temp as $item)
                    <img class="w-3/12 inline-block bg-white shadow overflow-hidden sm:rounded-lg ml-5 border border-gray-300"
                        src="{{ $item->temporaryUrl() }}">
                @endforeach

            @elseif($images_temp!="")
                <img class="w-3/12 inline-block bg-white shadow overflow-hidden sm:rounded-lg ml-5 border border-gray-300"
                    src="{{ $images_temp->temporaryUrl() }}">



            @endif
        @endif

        @if ($edit_var)
            @if ($multiple && $images_saved)
                <div>
                    @foreach ($images_saved as $item)
                        <div wire:key="{{$item->id}}"
                            class="w-3/12 inline-block bg-white relative overflow-hidden rounded-lg ml-5 border border-gray-300">
                            <img src="/storage/rooms/{{ $item->image }}?{{rand(1,300)}}">
                            
                            <div x-data="{show:false}" class="text-center bg-red-700 text-white ">        
                                <div 
                                    class="cursor-pointer p-2 " 
                                    @click="show=true"
                                    >
                                    <svg class="h-5 w-5  inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>
                                 <span class="text-sm font-semibold">Eliminar</span>
                                </div>  
                                <div x-show="show" class="text-left">
                                    <div class="absolute inset-0 bg-white"></div>
                                    <div class="absolute flex flex-col items-center inset-0  p-2 text-gray-500 text-sm justify-center ">
                                        <div 
                                        wire:loading.remove 
                                        wire:target="removeImg({{$item->id}})"
                                        class="flex flex-col justify-between items-center">
                                            
                                            <p>Seguro que deseas eliminar esta imagen?</p>
                                            <button wire:click="removeImg({{$item->id}})"  class="p-2 px-4
                                             font-bold bg-red-600 text-white rounded-lg">Eliminar </button>
                                        
                                        </div>
                                        
                                        
                                        <div wire:loading wire:target="removeImg({{$item->id}})">
                                                <svg class="animate-spin h-7 w-7 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                        
                                    </div>
                                    
                                </div>     
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            @elseif($images_saved)
                <img class="w-3/12 inline-block bg-white  overflow-hidden sm:rounded-lg ml-5 border border-gray-300"
                    src="/storage/rooms/thumbnail/{{ $images_saved }}?{{rand(1,300)}}" alt="img_saved">
            @endif
        @endif



    </div>
</div>
