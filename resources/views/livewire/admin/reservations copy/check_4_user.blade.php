<div>
    <h2 class="text-lg mb-2">Datos del cliente</h2>
    <div class="grid grid-cols-2 gap-4">


        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                Nombre Y Apellido
                @error('client.name')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror
            </label>
            <x-jet-input id="name" type="text" wire:model.defer="client.name"></x-jet-input>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefono
                @error('client.phone')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror
            </label>
            <x-jet-input id="phone" type="text" wire:model.defer="client.phone">
            </x-jet-input>
        </div>
        <!---------------------------->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email
                @error('email')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror

            </label>
            <x-jet-input id="email" type="email" wire:model.defer="email">
            </x-jet-input>
        </div>

        <div>
            <label for="c_email" class="block text-sm font-medium text-gray-700">
                Confirmar email
            </label>
            <x-jet-input id="c_email" type="email" wire:model.defer="email_confirmation"></x-jet-input>
        </div>

        <div>
            <label for="country" class="block text-sm font-medium text-gray-700">Pais
                @error('client.country')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror
            </label>
            <x-jet-input id="country" type="text" wire:model.defer="client.country">
            </x-jet-input>
        </div>

        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">Ciudad
                @error('client.city')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror

            </label>
            <x-jet-input id="city" type="text" wire:model.defer="client.city"></x-jet-input>
        </div>
        <!---------------------------->
        <div x-data="{check_in:''}" x-init="
        
        check_in = flatpickr($refs.check_in, {                                                               
            enableTime: true,
            noCalendar: true,                                        
            dateFormat: 'G:i K',                                        
            time_24hr: false,
            defaultDate:'{{ $this->reservation->check_in }}'
            
        });">
            <label for="check_in_date" class="block text-sm font-medium text-gray-700">
                Hora de llegada
                @error('reservation.check_in')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror

            </label>
            <x-jet-input x-ref="check_in" id="check_in_date" type="text" wire:model.defer="reservation.check_in">
            </x-jet-input>
        </div>


        <!---------------------------->
        <div class="special_request col-span-2">

            <label for="special_request" class="block text-sm font-medium text-gray-700">
                Peticion
                especial
                @error('reservation.end_date')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror
            </Label>

            <div class="mt-1">
                <textarea id="special_request" name="about" rows="3"
                    class="form-input rounded-md mt-1 focus:border-gray-500 block w-full focus:shadow-none sm:text-sm border-gray-300 border-1"
                    placeholder="Algo a tener en cuenta...." wire:model.defer="reservation.special_request"></textarea>
            </div>
        </div>
    </div>
</div>
