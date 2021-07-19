<div class="mx-auto max-w-5xl space-y-8">
    <h2 class="text-4xl font-bold text-gray-700">Agregue paquetes adicionale</h2>
    
    <div class="grid grid-cols-2 gap-5">
        <template x-for="complement in complements" :key="complement.id">             
            

            <div class="flex item-start border border-gray-200 p-4 rounded-lg space-x-3">
                <div>
                    <input x-on:click="complement_selected(complement.id,$event.target.checked)" type="checkbox"
                        class="h-5 w-5" :value="complement.id" >
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
                x-on:click="step_3_confirmation"
                :class="{ 'bg-orange-400' : isLoading , 'bg-orange-500' : ! isLoading }">
                

                <span x-show="!isLoading">
                    Confirmar datos
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
                        <span>Confirmando...</span>
                    </div>
                </div>

            </button>
            </div>
        </div>
    </div>
    
</div>