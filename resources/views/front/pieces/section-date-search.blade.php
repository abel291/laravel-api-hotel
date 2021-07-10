<div>
    <form class="py-4 text-gray-500 flex flex-col lg:flex-row lg:space-x-6  space-y-3 lg:space-y-0 ">

        <div class="flex border border-gray-300 rounded-md w-full lg:w-1/2">

            <div class="w-full py-2 px-4 inline-flex space-x-2 items-center  border-r border-gray-300 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <input class="w-full focus:outline-none capitalize" type="text" placeholder="Fecha Entrada">
            </div>

            <div class="w-full py-2 px-4 inline-flex space-x-2 items-center  ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <input class="w-full focus:outline-none capitalize" type="text" placeholder="Fecha Salida">
            </div>

        </div>

        <div class="flex w-full lg:w-1/2 justify-between lg:justify-start md:space-x-8">
            <div class="py-2 px-4 flex space-x-2 items-center  border border-gray-300 rounded-md ">
                <label for="adults" class="font-bold text-gray-500">Adultos:</label>

                <select class="focus:outline-none w-10 rounded-md border-gray-300" name="adults" id="adults">
                    <option value="1">1 </option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="">
                <button
                    class="focus:outline-none text-sm h-full py-2 px-5 bg-orange-500 rounded-full text-white font-bold">Chekear
                    Disponibilidad</button>
            </div>
        </div>


    </form>
</div>