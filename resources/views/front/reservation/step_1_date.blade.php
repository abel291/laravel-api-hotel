<div class="max-w-xl mx-auto  text-gray-700 space-y-8">
    <h2 class="text-4xl font-bold">Elija las Fechas</h2>

    <div class="flex space-x-3">

        <div class="w-1/2 ">

            <label class="mb-2 block font-bold text-gray-600 " for="start_date">
                Fecha de inicio
            </label>

            <input x-init="start_date='{{$start_date->format('Y-m-d') }}'" x-model="start_date"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="step_1_start_date"
                type="text" :disabled="isLoading">
            <span x-text="errors.start_date" class="pl-1 text-red-500 text-sm block"></span>

        </div>

        <div class="w-1/2 ">

            <label class="mb-2 block font-bold text-gray-600" for="end_date">
                Fecha de salida
            </label>

            <input x-init="end_date='{{$end_date->format('Y-m-d') }}'" x-model="end_date"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="step_1_end_date"
                type="text" :disabled="isLoading">
            <span x-text="errors.end_date" class="pl-1 text-red-500 text-sm block"></span>
        </div>

    </div>
    <div class="flex space-x-3 w-1/2">

        <div class="w-1/2 ">

            <label class="mb-2 block font-bold text-gray-600 " for="adults">
                Adultos
            </label>

            <select class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none appearance-none"
                id="adults" x-model.number="adults" :disabled="isLoading">
                <option value="1" >1 Adulto</option>
                <option value="2">2 Adultos</option>
                <option value="3">3 Adultos</option>
                <option value="4">4 Adultos</option>
                <option value="5">5 Adultos</option>
                <option value="6">6 Adultos</option>
            </select>
            <span x-text="errors.adults" class="pl-1 text-red-500 text-sm block"></span>

        </div>

        <div class="w-1/2 ">

            <label class="mb-2 block font-bold text-gray-600 " for="kids">
                Niños
            </label>

            <select id="kids" x-model.number="kids" :disabled="isLoading"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none appearance-none">
                <option value="1" >1 Niño</option>
                <option value="2">2 Niños</option>
                <option value="3">3 Niños</option>
                <option value="4">4 Niños</option>
                <option value="5">5 Niños</option>
                <option value="6">6 Niños</option>
            </select>
            <span x-text="errors.kids" class="pl-1 text-red-500 text-sm block"></span>
        </div>

    </div>


    <div class="flex space-x-3 justify-end">
        <div class="">
            <a href="/"
                class="block text-center font-bold w-full py-3 px-12 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-300 focus:outline-none ">Cancelar</a>
        </div>
        <div class="">
            <button class="font-bold py-3 w-64 rounded-full  text-white  focus:outline-none "
                x-on:click="step_1_check_date"
                :class="{ 'bg-orange-400' : isLoading , 'bg-orange-500' : ! isLoading }">

                <span x-show="!isLoading" >
                    Chekear disponibilidad
                </span>

                <div x-show="isLoading"  >
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
                        <span>Chekeando...</span>
                        
                    </div>
                </div>

            </button>
        </div>
    </div>
</div>