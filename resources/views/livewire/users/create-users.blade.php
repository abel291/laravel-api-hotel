
<div>
    <div x-data="{
        show : @entangle('open').defer ,
        edit : false      
        }" @open-modal.window="show = true ; edit = true">

        <x-modal>

            <x-slot name="button">
                <x-jet-button @click="
                    show = true ; 
                    edit = false; 
                    document.getElementById('form-modal').reset(); 
                    ">Agregar Usuario</x-jet-button>
            </x-slot>

            <x-slot name="title">
                <h2>Usuarios</h2>
            </x-slot>

            <x-slot name="content">

                <form id="form-modal">
                    <x-jet-label>
                        Nombre
                        @error('name')
                            <span class="error text-sm text-red-600 ml-1">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3" type="text" wire:model.defer="name"></x-jet-input>


                    <x-jet-label>
                        Email
                        @error('email')
                            <span class="error text-sm text-red-600 ml-3">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3" type="email" wire:model.defer="email"></x-jet-input>


                    <x-jet-label>
                        Telefono
                        @error('phone')
                            <span class="error text-sm text-red-600 ml-3">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3" type="text" wire:model.defer="phone"></x-jet-input>


                    <x-jet-label>
                        Contraseña
                        @error('password')
                            <span class="error text-sm text-red-600 ml-3">{{ $message }}</span>
                        @enderror
                    </x-jet-label>
                    <x-jet-input class="mb-3" type="password" wire:model.defer="password"></x-jet-input>


                    <x-jet-label>Confirmar Contraseña</x-jet-label>
                    <x-jet-input class="mb-3" type="password" wire:model.defer="password_confirmation"></x-jet-input>
                </form>



            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button @click="show = false" wire:loading.attr="disabled">
                    cancelar
                </x-jet-secondary-button>

                <x-jet-button x-show="!edit" class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    Agregar
                </x-jet-button>
                <x-jet-button x-show="edit" class="ml-2" wire:click="update({{ $this->user_id }})"
                    wire:loading.attr="disabled">
                    Editar
                </x-jet-button>
            </x-slot>
        </x-modal>    
    </div>
    
    <div x-data="{
            show :@entangle('open_modal_confirmation').defer,
            id:''
        }" 
        @open-modal-confirmation.window="show = true;id=$event.detail">

        <x-modal>   
                <x-slot name="button"></x-slot>
                <x-slot name="title">
                    Borrar Usuario
                </x-slot>

                <x-slot name="content">
                    ¿Estás seguro de que deseas eliminar este usuario?
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button @click="show=false" wire:loading.attr="disabled">
                        cancelar
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" @click="$wire.delete(id)" wire:loading.attr="disabled">
                        Borrar Usuario
                    </x-jet-danger-button>
                </x-slot>
        </x-modal>
    </div>
</div>
