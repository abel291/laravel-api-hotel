<div class="mx-auto max-w-5xl space-y-8">
    <h2 class="text-4xl font-bold text-gray-700">Agregue paquetes adicionale</h2>
    
    <div class="grid grid-cols-2 gap-5">
        <template x-for="complement in complements">
            
                
            

            <div class="flex item-start border border-gray-200 p-4 rounded-lg space-x-3">
                <div>
                    <input x-on:click="complement_selected(complement.id,$event.target.checked)" type="checkbox"
                        class="h-5 w-5" :value="complement.id">
                </div>
                <div class="flex flex-col text-gray-700 ">
                    <span class="font-bold " x-text="complement.name"></span>
                    <p class="text-sm text-gray-400"  x-text="complement.description_min"></p>
                    <div class="mt-3 ">
                        <span class="font-bold text-lg" x-text="formatNumber(complement.price)"></span>

                        <span class="text-sm" x-show="complement.type_price == 'reservation'">por reservacion</span>

                        <span class="text-sm" x-show="complement.type_price == 'night'">por noche</span>

                    </div>

                </div>
            </div>
            
        </template>
    </div>
    
    <div class="mt-5">
        <div class="flex space-x-3 justify-end">

            <div class="">
                <button x-on:click="step=2"
                    class="font-bold w-full py-3 px-14 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-300 focus:outline-none ">Volver</button>
            </div>

            <div class="">
                <button class="font-bold py-3 w-64 rounded-full  text-white bg-orange-500 focus:outline-none "
                    x-on:click="step_3_complements">
                    <span>
                        Seguir
                    </span>
                </button>
            </div>
        </div>
    </div>
    
</div>