<div>
    <div x-data="{
        show : false}">

        <x-modal>
            <x-slot name="button">
                <x-jet-button  x-on:click="show = true ;">Crear Reservation</x-jet-button>
            </x-slot>
            <x-slot name="title">
                <h2 class="font-bold text-gray-700">Crear Reservation</h2>
            </x-slot>
            <x-slot name="content">
                <div>
                    <div x-data>

                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
            </x-slot>
        </x-modal>
    </div>




</div>
