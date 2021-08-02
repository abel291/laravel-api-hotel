<div class="max-w-5xl mx-auto space-y-10 text-gray-700">

    <!-- tu orden-->
    <div class="space-y-5">
        <h2 class="text-4xl font-bold ">Tu orden</h2>

        <table class="min-w-full ">
            <thead>
                <tr class="uppercase border-b border-gray-200">

                    <th class="px-4 py-2 text-left font-semibold">Producto</th>
                    <th class="px-4 py-2 text-left font-semibold">Entrada - Salida</th>
                    <th class="px-4 py-2 text-left font-semibold">Precio</th>
                    <th class="px-4 py-2 text-left font-semibold">Habitaciones</th>
                    <th class="px-4 py-2 text-left font-semibold">Total</th>
                </tr>
            </thead>
            <tr class="border-b border-gray-200">

                <td class="px-4 py-2 text-xl font-bold capitalize">
                    <span x-text="room_selected.name"></span>
                </td>
                <td class="px-4 py-2 ">
                    <span x-text="start_date + ' - ' + end_date"></span>
                </td>

                <td class="px-4 py-2 ">
                    <span x-text=formatNumber(room_selected.price_per_total_night)></span>
                </td>
                <td class="px-4 py-2 ">
                    <span x-text="room_quantity"></span>
                </td>
                <td class="px-4 py-2 ">
                    <span x-text=formatNumber(price_per_reservation)></span>
                </td>
            </tr>
            <template x-for="com in complements_cheked">
                <tr class="border-b border-gray-200">
                    <td class="pl-10 py-2">
                        <span class="text-green-500 font-bold"> -Adicioinal- </span>
                        <span x-text="com.name"></span>
                    </td>

                    <td class="px-4 py-2">
                        <span x-text="start_date + ' - ' + end_date"></span>
                    </td>

                    <td class="px-4 py-2">

                        <span x-text="formatNumber(com.price_per_total_night)"></span>
                    </td>

                    <td class="px-4 py-2">
                        <span x-text="room_quantity"></span>
                    </td>

                    <td class="px-4 py-2">
                        <span x-text="formatNumber(com.total_price)"></span>
                    </td>

                </tr>
            </template>
        </table>
        <div>
            <div class="flex">
                <input placeholder="Codigo" x-model="discount.code"
                    class="py-2 px-4 border border-gray-300 rounded-md focus:outline-none uppercase" type="text">
                <button x-on:click="applyCodeDiscount"
                    class="ml-3 font-bold px-8  text-white rounded-full bg-orange-500 focus:bg-orange-400 text-center focus:outline-none">Aplicar
                    Cupon</button>
            </div>
            <span x-show="discount.error_input" x-text='discount.error_input'
                class="mt-2 text-red-600 text-sm block"></span>
        </div>
    </div>
    <!-- total -->
    <div class="space-y-5">
        <h2 class="text-4xl font-bold  pt-8">Total</h2>
        <table class="w-1/2 ">

            <tr class="border-b border-gray-200">
                <td class="p-4 font-bold">
                    SUB-TOTAL
                </td>
                <td>
                    <span x-text="formatNumber(sub_total_price)"></span>
                </td>


            </tr>
            <tr x-show="discount.amount" class="border-b border-gray-200">
                <td class="p-4 font-bold">
                    <span>CUPON DE DESCUENTO</span>
                </td>
                <td class="text-green-500 font-semibold ">
                    <span x-text="formatNumber(-discount.amount)"></span>
                </td>

            </tr>
            <tr class="border-b border-gray-200">
                <td class="p-4 font-bold text-xl ">
                    TOTAL
                </td>
                <td>
                    <span class=" font-bold text-lg" x-text="formatNumber(total_price)"></span>
                </td>
            </tr>

        </table>

    </div>
    <!-- form data user -->
    <div class="space-y-5">
        <h2 class="text-4xl font-bold ">Detalles de facturación</h2>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="name" class="mb-2 block font-bold text-gray-600 ">Nombre Y Apellido</label>
                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="name"
                    type="text" x-model="client.name" x-init="client.name='{{$client->name}}'">
            </div>

            <div>
                <label for="phone" class="mb-2 block font-bold text-gray-600 ">Telefono</label>
                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="phone"
                    type="text" x-model="client.phone" x-init="client.phone='{{$client->phone}}'">

            </div>
            <!---------------------------->
            <div>
                <label for="email" class="mb-2 block font-bold text-gray-600 ">Email </label>
                <input x-model="client.email" x-init="client.email='{{$client->email}}'"
                    class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="email"
                    type="email">

            </div>

            <div>
                <label for=" c_email" class="mb-2 block font-bold text-gray-600 ">Confirmar email</label>
                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="c_email"
                    type="email" x-model="client.email_confirmation"
                    x-init="client.email_confirmation='{{$client->email}}'">


            </div>

            <div>
                <label for=" country" class="mb-2 block font-bold text-gray-600 ">Pais</label>
                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="country"
                    type="text" x-model="client.country" x-init="client.country='{{$client->country}}'">

            </div>

            <div>
                <label for="city" class="mb-2 block font-bold text-gray-600 ">Ciudad</label>
                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="city"
                    type="text" x-model="client.city" x-init="client.city='{{$client->city}}'">
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
                <label for="check_in_date" class="mb-2 block font-bold text-gray-600">Hora de llegada</label>
                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" x-ref="check_in"
                    id="check_in_date" type="text" x-model="client.check_in">

            </div>
            <!---------------------------->
            <div class="special_request col-span-2">

                <label for="special_request" class="mb-2 block font-bold text-gray-600 ">Peticion especial</Label>

                <div class="mt-1">
                    <textarea id="special_request" name="about" rows="3"
                        class="form-input rounded-md mt-1 focus:border-gray-500 block w-full focus:shadow-none  border-gray-300 border-1"
                        placeholder="Algo a tener en cuenta...." x-model="client.special_request"
                        x-init="client.special_request='{{$client->special_request}}'"></textarea>

                </div>
            </div>
        </div>
    </div>
    <!-- input stripe -->
    <div class="space-y-5">
        <h3 class="text-4xl font-bold ">Pago con tarjeta</h3>
        <div class="space-y-4">

            <div class="sm:w-1/2 space-y-2 ">
                <label for="card-holder-name" class="block text-sm font-medium ">
                    Nombre del titular
                </label>

                <input class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none uppercase"
                    type="text" placeholder="como aparece en la targeta" x-model='stripe.name'
                    x-init="stripe.name='{{$client->name}}'">
                <span x-text='stripe.error_name' class="pl-1 text-red-600 text-sm block"></span>
            </div>

            <div class="sm:w-1/2 space-y-2">
                <label for="card-holder-name" class="block text-sm font-medium ">
                    Numero de Targeta</label>

                <div id="card-element"
                    class="w-full p-2.5 border border-gray-300 rounded-md focus:outline-none capitalize"
                    stripe-key="{{env('STRIPE_KEY')}}">
                </div>

                <span x-text='stripe.error_card' class="pl-1 text-red-600 text-sm block"></span>

            </div>
        </div>
    </div>

    <!-- buttom -->
    {{-- <div class="flex space-x-3 justify-end">
        <div>
            <button x-on:click="step=3"
                class="btn_back_step_reservation ">Volver</button>
        </div>
        <div class="">
            <button id='card-button'
                class="font-bold py-3 w-64 rounded-full  text-white bg-orange-500 focus:outline-none "
                :class="{ 'bg-orange-400 cursor-default' : isLoading , 'bg-orange-500' : !isLoading}" :disabled="isLoading">

                <span x-show="!isLoading">
                    Reservar habitacion
                </span>
                <div x-show="isLoading">
                    <div class="flex items-center justify-center">
                        <div>
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                        <span>Chekeando datos...</span>
                    </div>
                </div>

            </button>
        </div>
    </div> --}}
    <div class="flex space-x-3 justify-end">
        <button x-on:click="step=3;scroll_top()" class="btn_back_step_reservation">
            Volver
        </button>

        <button class="btn_next_step_reservation" x-show="step==4" id="button_stripe"> Reservar habitacion
        </button>
    </div>
</div>