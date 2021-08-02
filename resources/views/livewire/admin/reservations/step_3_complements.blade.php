<div class="space-y-8">
    <div class="grid grid-cols-2 gap-3">
        <template x-for="complement in complements" :key="complement.id">

            <div class="flex item-start border border-gray-200 p-4 rounded-lg space-x-3">
                <div>
                    <input x-on:click="complement_selected(complement.id,$event.target.checked)" type="checkbox"
                        class="form-checkbox text-gray-700 h-5 w-5" :value="complement.id">
                </div>
                <div class="flex flex-col text-gray-700 justify-between ">
                    <div>
                        <span class="font-bold " x-text="complement.name"></span>
                        <p class="text-sm text-gray-400" x-text="complement.description_min"></p>
                    </div>
                    <div class="mt-4">
                        <span class="font-bold text-lg" x-text="formatNumber(complement.price)"></span>

                        <span class="text-sm" x-show="complement.type_price == 'reservation'">por reservacion</span>

                        <span class="text-sm" x-show="complement.type_price == 'night'">por noche</span>

                    </div>

                </div>
            </div>

        </template>
    </div>

    {{-- <div class="flex space-x-3 justify-between">
        @include('livewire.admin.reservations.button_step',[
        'button_back_step'=>2,
        'step_alpine_fuction'=>'step_3_confirmation',
        'text'=>'Seguir',
        'text_loading'=>'Chekeando...'
        ])
    </div> --}}


</div>