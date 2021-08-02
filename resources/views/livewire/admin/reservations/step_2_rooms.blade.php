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


            </div>
        </template>


    </div>
   
</div>