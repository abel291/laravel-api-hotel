<div class="space-y-8">
    <div class="space-y-8">
        <template x-for="room in rooms" :key="room.id">
            <div class="flex  rounded overflow-hidden border border-gray-100">
                <div class="w-40">
                    <img :src="'/storage/rooms/thumbnail/'+room.thumbnail" class="w-full object-coverimg-list-room">
                </div>
                <div class="flex flex-col space-y-2 flex-grow px-4 py-2">
                    <a class="font-bold capitalize" x-text="room.name" :href="'/room/'+room.slug"
                        target="_blank"></a>
                    <div class=" flex space-x-4 w-full text-sm text-gray-600">
                        <div>
                            <span>Camas: </span><span class="font-semibold" x-text="room.beds"> </span>
                        </div>
                        <div>
                            <span>Adultos: </span><span class="font-semibold" x-text="+room.adults"> </span>
                        </div>
                        <div>
                            <span>Niños: </span><span class="font-semibold" x-text="room.kids"> </span>
                        </div>
                    </div>

                    <div class="">
                        <span class="font-bold" x-text="formatNumber(room.price)"></span>
                        <span class="text-sm">/ noche</span>
                    </div>


                    
                        <div class="flex justify-between items-end flex-grow">
                            <select :id="'quantity_availables_' + room.id" class="form-select block text-sm">
                                <template x-for="(price,i) in room.price_per_quantity_room_selected">
                                    <option :value="i" x-text="i+' - ' + formatNumber(price)"></option>
                                </template>
                            </select>

                            <x-jet-button x-on:click="step_2_select_room(room.id)">Reservar</x-jet-button>

                        </div>
                    

                </div>

                {{-- <div class="shadow-md hover:shadow-xl transition-shadow duration-300  rounded-lg overflow-hidden">
                    <div class="relative overflow-hidden">
                        <a :href="'/room/'+room.slug" target="_blank" class="w-full  ">
                            <img :src="'/storage/rooms/thumbnail/'+room.thumbnail"
                                class="w-full h-64 object-cover transition duration-500 transform hover:scale-110 img-list-room">

                            <div class="text-white leading-tight space-y-1 py-4 px-4 absolute bottom-0 left-0">
                                <h3 class="font-semibold text-xl" x-text="room.name"></h3>
                                <p class="text-xl font-light">
                                    <span class="text-2xl font-semibold" x-text="formatNumber(room.price)"></span>

                                    <span class="text-base">/ noche</span>
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="flex flex-wrap p-4  text-gray-600 border-gray-200 md:border-none border space-y-4">
                        <div class="flex items-center w-full text-sm space-x-4">
                            <span class="font-bold" x-text="'Camas: '+room.beds"> </span>
                            <span class="font-bold" x-text="'Adultos: '+room.adults"> </span>
                            <span class="font-bold" x-text="'Niños: '+room.kids"> </span>
                        </div>

                        <div class="w-full">
                            <select :id="'quantity_availables_' + room.id"
                                class="w-full py-2 px-6 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                                <template x-for="(price,i) in room.price_per_quantity_room_selected">

                                    <option class="p-1" :value="i" x-text="i+' - ' + formatNumber(price)"></option>

                                </template>

                            </select>
                        </div>

                        <button x-on:click="step_2_select_room(room.id)"
                            class="w-full py-2 px-4 bg-orange-500 text-white font-bold rounded-full focus:outline-none ">
                            Reservar
                        </button>

                    </div>
                </div> --}}

            </div>
        </template>


    </div>
    <div class="flex space-x-3 justify-between">
        @include('livewire.admin.reservations.button_step',[
            'button_back_step'=>1,
            'step_alpine_fuction'=>'',
            'text'=>'',
            'text_loading'=>''
        ])
    </div>
</div>