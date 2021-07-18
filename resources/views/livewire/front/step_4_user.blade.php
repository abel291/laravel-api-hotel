<div class="max-w-5xl mx-auto space-y-16">
    
    <div class="space-y-4">
        <h2 class="text-4xl font-bold text-gray-700">Tu orden</h2>

        <table class="min-w-full text-gray-700">
            <thead>
                <tr class="uppercase border-b border-gray-200">
                    <th></th>
                    <th class="px-4 py-2 text-left font-semibold">Producto</th>
                    <th class="px-4 py-2 text-left font-semibold">Entrada - Salida</th>
                    <th class="px-4 py-2 text-left font-semibold">Precio</th>
                    <th class="px-4 py-2 text-left font-semibold">Habitaciones</th>
                    <th class="px-4 py-2 text-left font-semibold">Total</th>
                </tr>
            </thead>
            <tr class="border-b border-gray-200">
                <td class="px-4 py-6">
                    <img :src="'/storage/rooms/thumbnail/'+room_selected.thumbnail"
                        class="w-20 h-20  object-cover rounded-md">
                </td>
                <td class="px-4 py-6 text-xl font-bold capitalize">

                    <div class="flex items-center space-x-5 ">

                        <span x-text=room_selected.name></span>
                    </div>
                </td>
                <td class="p-4 ">
                    <span x-text="start_date + ' - ' + end_date"></span>
                </td>
                <td class="p-4 ">
                    <span x-text=formatNumber(room_selected.price_per_total_night)></span>
                </td>
                <td class="p-4 ">
                    <span x-text="room_quantity"></span>
                </td>
                <td class="p-4 ">
                    <span x-text=formatNumber(room_selected.total_price_per_reservation)></span>
                </td>
            </tr>
            <template x-for="com in complements_cheked">
                <tr class="border-b border-gray-200">
                    <td></td>

                    <td class="pl-10 py-2 pr-4 ">
                        <span class="text-green-500 font-bold"> -Adicioinal- </span>
                        <span x-text="com.name"></span>
                    </td>

                    <td class="px-4 py-2">
                        <span x-text="start_date + ' - ' + end_date"></span>
                    </td>

                    <td class="px-4 py-2">

                        <span x-text="formatNumber(com.price)"></span>
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
    </div>
    
    <div class="space-y-4">
        <h2 class="text-4xl font-bold text-gray-700 pt-8">Total</h2>
        <table class="w-1/2 ">
            
            <tr class="border-b border-gray-200">
                <td class="px-4 py-6 font-bold">
                    SUB-TOTAL
                </td>
                <td>
                    <span x-text="formatNumber(total_price)"></span>
                </td>


            </tr>
            <tr class="border-b border-gray-200">
                <td class="px-4 py-6 font-bold">
                    TOTAL
                </td>
                <td>
                    <span class=" font-bold text-lg" x-text="formatNumber(total_price)"></span>
                </td>
            </tr>

        </table>
    </div>

    <div class="flex space-x-3 justify-end">
        <div>
            <button x-on:click="step=3"
                class="font-bold w-full py-3 px-14 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-300 focus:outline-none ">Volver</button>
        </div>
        <div class="">
            <button class="font-bold py-3 w-64 rounded-full  text-white bg-orange-500 focus:outline-none "
                x-on:click="step_5_chekout"
                :class="{ 'bg-orange-300' : isLoading , 'bg-orange-500' : !isLoading}"
                >

                <span x-show="!isLoading">
                    Ultimno paso
                </span>
                <div x-show="isLoading">
                    <div class="flex items-center justify-center" >
                        <div>
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
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
    </div>

</div>