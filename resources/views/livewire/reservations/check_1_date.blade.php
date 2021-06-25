<div>

    <div class="flex  w-full sm:w-3/4" x-data="{
        calendar_end_date:'',
        calendar_start_date:'',
        
    }" x-init="
        
        calendar_end_date = flatpickr($refs.end_date, {                
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            minDate: '{{ $this->reservation->end_date->format('Y-m-d') }}',
            defaultDate:'{{ $this->reservation->end_date->format('Y-m-d') }}'
        });
        calendar_start_date =  flatpickr($refs.start_date, {                
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            minDate: 'today',
            defaultDate: '{{ $this->reservation->start_date->format('Y-m-d') }}' ,

            onClose: function(selectedDates, dateStr, instance){
                
                addDays=selectedDates[0].fp_incr(1)
                if(selectedDates[0] >= calendar_end_date.selectedDates[0]){
                    
                    calendar_end_date.setDate(addDays)
                    
                    
                }                                        
                calendar_end_date.config.minDate = addDays //add +1 days
                $refs.end_date.dispatchEvent(new Event('input'));
                   
            }                                
        });
        
    ">
        <div class="mr-4">
            <x-jet-label>
                Fechas de Llegada
                @error('reservation.start_date')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror
            </x-jet-label>

            <x-jet-input x-ref="start_date" class="mb-3  " type="text" wire:model.defer="reservation.start_date">
            </x-jet-input>
        </div>

        <div class="mr-4">

            <x-jet-label>
                Fechas de salida
                @error('reservation.end_date')
                    <span class="error text-sm text-red-600 block">{{ $message }}</span>
                @enderror
            </x-jet-label>

            <x-jet-input x-ref="end_date" class="mb-3 " type="text" wire:model.defer="reservation.end_date">
            </x-jet-input>
        </div>

    </div>
    <div class="flex w-full">
        <div class="mr-4 w-28">

            <x-jet-label>Adultos</x-jet-label>
            <x-jet-input class="mb-3 " type="number" wire:model.defer="adults">
            </x-jet-input>

        </div>

    </div>
    <x-jet-button wire:click="check_1_date" wire:loading.attr="disabled">
        chequear
    </x-jet-button>
</div>
