<div>
    <div class="max-w-5xl  mx-auto space-y-12">
        <div class="space-y-6">
            <h2 class="text-4xl font-bold text-gray-700">Orden recibida</h2>
                <div class="flex items-center text-green-500 space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                    <span class="font-bold">Gracias. Tu orden ha sido recibida.</span>
                </div>
            <div class="flex item-stretch  divide-x divide-gray-200">
                <div class="px-5">
                    <span class=" uppercase text-xs text-gray-700">numero de orden</span>
                    <div class=" font-bold text-gray-700" x-text="order"></div>
                </div>
                <div class="px-5">
                    <span class=" uppercase text-xs text-gray-700">Fecha</span>
                    <div class=" font-bold text-gray-700" x-text="pay_date"></div>
                </div>
                <div class="px-5">
                    <span class=" uppercase text-xs text-gray-700">total</span>
                    <div class=" font-bold text-gray-700" x-text="formatNumber(total_price)"></div>
                </div>
                <div class="px-5">
                    <span class=" uppercase text-xs text-gray-700">metodo de pago</span>
                    <div class=" font-bold text-gray-700">Targeta de credito</div>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <h2 class="text-4xl font-bold text-gray-700">Detalles de orden</h2>
            <table class="min-w-full text-gray-700 ">
                <tbody class="divide-y divide-gray-200 space-y-4">
                <tr class=" uppercase">
                    <td class="py-5">Productos</td>
                    <td>Total</td>
                </tr>               

                <tr>
                    <td class="py-5 font-bold">
                        <span x-show="night > 1" x-text="room_selected.name"></span>                        
                        <span x-show="night==1" x-text="room_selected.name + ' × ' + night "></span>                        
                    </td>                    
                    <td>
                        <span x-text=formatNumber(price_per_reservation)></span>
                    </td>
                </tr>
                <template x-for="com in complements_cheked">
                    <tr>
                        <td class="py-5 font-bold">
                            <span x-show="night > 1" x-text="com.name"></span>                        
                            <span x-show="night==1" x-text="com.name+ ' × ' + night "></span>                        
                        </td>                    
                        <td>
                            <span x-text=formatNumber(com.total_price)></span>
                        </td>
                    </tr>
                </template>
                <tr>
                    <td class="py-5">
                        <span class="font-bold">SUB-TOTAL</span>    
                    </td>
                    <td>
                        <span class="font-bold" x-text=formatNumber(total_price)></span>
                    </td>
                </tr>
                <tr>
                    <td class="py-5">
                        <span class="font-bold">METODO DE PAGO</span>    
                    </td>
                    <td >
                        <span class="font-bold"> Targeta de credito  </span>
                    </td>
                </tr>
                <tr>
                    <td class="py-5">
                        <span class="font-bold">TOTAL</span>    
                    </td>
                    <td>
                        <span class="font-bold" x-text=formatNumber(total_price)></span>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>