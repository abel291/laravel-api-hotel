<div class="space-y-8">
    <!-- form data user -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-700">Detalles de facturación</h2>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <x-jet-label for="name">Nombre Y Apellido</x-jet-label>
                <x-jet-input id="name" type="text" x-model="client_name" x-init="client_name='{{$client->name}}'">
                </x-jet-input>
            </div>

            <div>
                <x-jet-label for="phone">Telefono</x-jet-label>
                <x-jet-input id="phone" type="text" x-model="client_phone" x-init="client_phone='{{$client->phone}}'">
                </x-jet-input>
            </div>
            <!---------------------------->
            <div>
                <x-jet-label for="email">Email </x-jet-label>
                <x-jet-input x-model="client_email" x-init="client_email='{{$client->email}}'" id="email" type="email">
                </x-jet-input>
            </div>

            <div>
                <x-jet-label for=" c_email">Confirmar email</x-jet-label>
                <x-jet-input id="c_email" type="email" x-model="client_email_confirmation"
                    x-init="client_email_confirmation='{{$client->email}}'"></x-jet-input>


            </div>

            <div>
                <x-jet-label for=" country">Pais</x-jet-label>
                <x-jet-input id="country" type="text" x-model="client_country"
                    x-init="client_country='{{$client->country}}'">
                </x-jet-input>
            </div>

            <div>
                <x-jet-label for="city">Ciudad</x-jet-label>
                <x-jet-input id="city" type="text" x-model="client_city" x-init="client_city='{{$client->city}}'">
                </x-jet-input>
            </div>
            <!---------------------------->
            <div x-data x-init="
                $nextTick(() => {            
                const check_in = flatpickr($refs.check_in, {                                                               
                        enableTime: true,
                        noCalendar: true,                                        
                        dateFormat: 'G:i K',                                        
                        time_24hr: false,
                        defaultDate:'2:00 PM'
                        
                    });
                });
                    ">
                <x-jet-label for="check_in_date">Hora de llegada</x-jet-label>
                <x-jet-input x-ref="check_in" id="check_in_date" type="text" x-model="client_check_in"></x-jet-input>

            </div>
            <!---------------------------->
            <div class="special_request col-span-2">

                <x-jet-label for="special_request">Peticion especial</x-jet-input>

                    <div class="mt-1">
                        <textarea id="special_request" name="about" rows="3" class="form-textarea w-full text-sm"
                            placeholder="Algo a tener en cuenta...." x-model="client_special_request"
                            x-init="client_special_request='{{$client->special_request}}'"></textarea>

                    </div>
            </div>
        </div>
    </div>
    <!-- order -->
    <div class="space-y-4 ">
        <h2 class="text-xl font-bold mb-4">Tu orden</h2>
        <div>
            <span class=" font-bold ">Fecha: </span><span x-text="start_date + '   ' + end_date"></span>
        </div>

        <table class="min-w-full text-gray-700">
            <thead>
                <tr class="uppercase border-b border-gray-200 text-sm text-left font-semibold space-x-4">
                    <th class="py-2">Producto</th>

                    <th class="py-2">Precio</th>
                    <th class="py-2">Habitaciones</th>
                    <th class="py-2">Total</th>
                </tr>
            </thead>
            <tr class="border-b border-gray-200 text-sm">

                <td class="py-2 pr-2 font-bold capitalize">
                    <span x-text="room_selected.name"></span>
                </td>
                <td class="pr-2">
                    <span x-text=formatNumber(room_selected.price_per_total_night)></span>
                </td>
                <td class="pr-2 text-center">
                    <span x-text="room_quantity"></span>
                </td>
                <td class="pr-2">
                    <span x-text=formatNumber(price_per_reservation)></span>
                </td>
            </tr>
            <template x-for="com in complements_cheked">
                <tr class="border-b border-gray-200 text-sm">
                    <td class="py-2 pr-2 pl-4">
                        <span x-text="com.name"></span>
                    </td>

                    <td class="pr-2">
                        <span x-text="formatNumber(com.price_per_total_night)"></span>
                    </td>

                    <td class="pr-2 text-center">
                        <span x-text="room_quantity"></span>
                    </td>

                    <td class="pr-2">
                        <span x-text="formatNumber(com.total_price)"></span>
                    </td>
                </tr>
            </template>

            <tr class="border-b border-gray-200 text-sm">
                <td colspan="3" class="pt-6 pb-2  pr-4 text-right ">
                    SUB-TOTAL
                </td>
                <td class="pt-6 pb-2">
                    <span x-text="formatNumber(total_price)"></span>
                </td>

            </tr>
            <tr class="border-b border-gray-200 text-sm font-bold">
                <td colspan="3" class="py-2 pr-4 text-right">
                    TOTAL
                </td>
                <td>
                    <span x-text="formatNumber(total_price)"></span>
                    <span x-ref='price_discount' class=" font-normal text-xs line-through text-gray-500"></span>
                </td>
            </tr>
        </table>
        <div>
        <div class="flex space-x-3">
            <input  placeholder="Codigo" type="text" maxlength="8" x-model="codeDiscount" class="sm:w-40 rounded-md block w-full  sm:text-sm border border-gray-300 form-input">
            
            <x-jet-button
                x-bind:class="{ 'bg-gray-500 cursor-default' : isLoading , 'bg-gray-800 hover:bg-gray-600' : ! isLoading }"
                x-bind:disabled="isLoading"
                x-on:click="applyCodeDiscount">

                <span class="" x-show="!isLoading">Aplicar Cupon</span>

                <div x-show="isLoading">
                    <div class="flex items-center justify-center ">
                        <div>
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-white">Cargando</span>

                    </div>
                </div>

            </x-jet-button>
        </div>
        <span x-show="error_input_code_discount" x-text='error_input_code_discount' class="mt-2 text-red-600 text-sm block"></span>
        </div>
    </div>

    <!-- inputs stripe -->
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-gray-700">Pago con tarjeta</h3>
        <div class="space-y-4 w-3/5">

            <div class="space-y-2 ">
                <label for="card-holder-name" class="block text-sm font-medium text-gray-700">
                    Nombre del titular

                </label>

                <x-jet-input type="text" placeholder="como aparece en la targeta" x-model='input_stripe_name'
                    x-init="input_stripe_name='{{$client->name}}'"></x-jet-input>
                
                    <span x-text='input_stripe_error_name' class="pl-1 text-red-600 text-sm block"></span>
            </div>

            <div class="space-y-2">
                <label for="card-holder-name" class="block text-sm font-medium text-gray-700">
                    Numero de Targeta</label>

                <div id="card-element" class="rounded-md bg-white p-2.5 border border-gray-300"
                    data-stripe_id="{{env('STRIPE_KEY')}}">
                </div>

                <span x-text='input_stripe_error_card' class="pl-1 text-red-600 text-sm block"></span>

            </div>
        </div>
    </div>

    <div class="flex space-x-3 justify-between">
        @include('livewire.admin.reservations.button_step',[
        'button_back_step'=>2,
        'step_alpine_fuction'=>'step_4_finalize',
        'text'=>'Reservar Habitacion',
        'text_loading'=>'Chekeando...'
        ])
    </div>
</div>