<div class="space-y-8">
    <div class="space-y-4 text-sm">
        <div class="bg-green-100 p-4 flex space-x-2 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            <div class="text-green-700">
                <span class="font-semibold block text-green-700">Orden completada</span>
                <span class="text-green-600"> Todo los datos han sido enviados a tu correo</span>
            </div>
        </div>

        <div class="flex item-stretch  divide-x divide-gray-200">
            <div class="px-4">
                <span class=" uppercase text-xs text-gray-700">numero de orden</span>
                <div class=" font-bold text-gray-700" x-text="'#' + order"></div>
            </div>
            <div class="px-4">
                <span class=" uppercase text-xs text-gray-700">Fecha</span>
                <div class=" font-bold text-gray-700" x-text="create_date"></div>
            </div>
            <div class="px-4">
                <span class=" uppercase text-xs text-gray-700">total</span>
                <div class=" font-bold text-gray-700" x-text="formatNumber(total_price)"></div>
            </div>
            <div class="px-4">
                <span class=" uppercase text-xs text-gray-700">metodo de pago</span>
                <div class=" font-bold text-gray-700">Targeta de credito</div>
            </div>
        </div>
    </div>
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-700">Detalles de orden</h2>
        <table class="min-w-full text-gray-700  text-sm">
            <tbody class="divide-y divide-gray-200">
                <tr class=" uppercase">
                    <td class="py-3">Productos</td>
                    <td>Total</td>
                </tr>

                <tr>
                    <td class="py-2 font-bold">
                        <span x-show="room_quantity > 1" x-text="room_selected.name"></span>
                        <span x-show="room_quantity==1" x-text="room_selected.name + ' × ' + room_quantity "></span>
                    </td>
                    <td>
                        <span x-text=formatNumber(price_per_reservation)></span>
                    </td>
                </tr>
                <template x-for="com in complements_cheked">
                    <tr>
                        <td class="py-2 font-bold">
                            <span x-show="room_quantity > 1" x-text="com.name"></span>
                            <span x-show="room_quantity == 1" x-text="com.name+ ' × ' + room_quantity "></span>
                        </td>
                        <td>
                            <span x-text=formatNumber(com.total_price)></span>
                        </td>
                    </tr>
                </template>
                <tr class="font-semibold">
                    <td class="py-2">
                        <span>METODO DE PAGO</span>
                    </td>
                    <td>
                        <span> Targeta de credito </span>
                    </td>
                </tr>
                <tr class="font-bold">
                    <td class="py-2">
                        <span>SUB-TOTAL</span>
                    </td>
                    <td>
                        <span x-text=formatNumber(sub_total_price)></span>
                    </td>
                </tr>
                <tr class="font-bold" x-show="discount.amount">
                    <td class="py-2  ">
                        <span>CUPON DE DESCUENTO</span> 
                    </td>
                    <td class="text-green-500 ">
                        <span x-text="formatNumber(-discount.amount)"></span>
                    </td>    
                </tr>
                
                <tr class="font-bold ">
                    <td class="py-2">
                        <span>TOTAL</span>
                    </td>
                    <td>
                        <span class="text-xl" x-text=formatNumber(total_price)></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>