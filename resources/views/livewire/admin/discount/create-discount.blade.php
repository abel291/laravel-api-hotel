<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; id=$event.detail; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button x-on:click="show = true" wire:click="create">Agregar Codigo</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Codigo de descuernto</h2>
            </x-slot>

            <x-slot name="content">
                <div>
                    <div>
                        <x-jet-label>
                            Codigo
                            @error('discount.code')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <x-jet-input maxlength=8 class="mb-3 w-full md:w-40 " type="text" wire:model.defer="discount.code">
                        </x-jet-input>
                    </div>

                    <!-- input precio -->
                    <div class=" flex space-x-2">
                        <div class="w-full md:w-28">
                            <x-jet-label>
                                Descuento
                                @error('discount.percent')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">
                                        %
                                    </span>
                                </div>
                                <x-jet-input  class="mb-3 pl-6" type='number' min="1" max="100" maxlength=3 wire:model.defer="discount.percent">
                                </x-jet-input>
                            
                            </div>                            
                        </div>
                        <div class="w-full md:w-28">
                            <x-jet-label>
                                Cantidad
                                @error('discount.quantity')
                                <span class="error text-sm text-red-600 block">{{ $message }}</span>
                                @enderror
                            </x-jet-label>
                            <x-jet-input type="number" wire:model.defer="discount.quantity"></x-jet-input>
                        </div>               
                    </div>
                    <div class="w-full">
                        <x-jet-label>
                            Estado
                            @error('discount.active')
                            <span class="error text-sm text-red-600 block">{{ $message }}</span>
                            @enderror
                        </x-jet-label>
                        <x-form.input-active wire:model.defer="discount.active"></x-form.input-active>
                    </div>


                </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button x-on:click="show = false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                @if (!$edit_var)
                <x-jet-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    Agregar
                </x-jet-button>
                @else
                <x-jet-button class="ml-2" x-on:click="$wire.update(id)" wire:loading.attr="disabled">
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
                Borrar codigo de descuento
            </x-slot>

            <x-slot name="content">
                Este codigo de descuento no se borrara para reservaciones ya hechas ,sin embargo no estaran disponibles para las
                futuras reservaciones , ¿estas seguro que desea eliminarla?
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" x-on:click="$wire.delete(id)" wire:loading.attr="disabled">
                    Borrar codigo
                </x-jet-danger-button>
            </x-slot>
        </x-modal>
    </div>
</div>