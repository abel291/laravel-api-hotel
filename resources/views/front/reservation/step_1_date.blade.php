<div class="max-w-xl mx-auto  text-gray-700 space-y-8">
    <h2 class="text-4xl font-bold">Elija las Fechas</h2>

    <div class="flex space-x-3">

        <div class="w-1/2 ">

            <label class="mb-2 block font-bold text-gray-600 " for="start_date">
                Fecha de inicio
            </label>

            <input date-default="{{$start_date}}" x-model="start_date"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none" id="step_1_start_date"
                type="text" :disabled="isLoading">
            <span x-text="errors.start_date" class="pl-1 text-red-500 text-sm block"></span>

        </div>

        <div class="w-1/2 ">

            <label class="mb-2 block font-bold text-gray-600" for="end_date">
                Fecha de salida
            </label>

            <input date-default="{{$end_date}}" x-model="end_date"
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

            <select x-init="adults='{{$adults}}'"
                class="w-full py-2 px-4 border border-gray-300 rounded-md focus:outline-none appearance-none"
                id="adults" x-model.number="adults" :disabled="isLoading">
                <option value="1">1 Adulto</option>
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
                <option value="0">0 Niños</option>
                <option value="1">1 Niño</option>
                <option value="2">2 Niños</option>
                <option value="3">3 Niños</option>
                <option value="4">4 Niños</option>
                <option value="5">5 Niños</option>
                <option value="6">6 Niños</option>
            </select>
            <span x-text="errors.kids" class="pl-1 text-red-500 text-sm block"></span>
        </div>

    </div>


    <div class="text-right">
        <button
            class="btn_next_step_reservation"
            x-show="step==1" x-on:click="step_1_check_date">Chekear disponibilidad
        </button>
    </div>
</div>