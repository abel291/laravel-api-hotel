<div>
    <div x-data="{
        show : @entangle('open').defer ,        
        }" @open-modal-edit.window="show = true ; $wire.edit($event.detail)">

        <x-modal>
            <x-slot name="button">
                <x-jet-button @click="show = true" wire:click=" create">Agregar reservacion
                </x-jet-button>
            </x-slot>

            <x-slot name="title">

            </x-slot>

            <x-slot name="content">

                <div>

                    <div class=" mx-auto mb-8 mt-8">
                        <div class="flex items-center">
                            @php
                                $items = ['Fechas', 'Habitaciones', 'Experiencias', 'Usuario', 'Confiramcion'];
                            @endphp
                            @foreach ($items as $key => $item_name)


                                <div class="w-1/5">
                                    <div class="relative mb-2">

                                        @if ($key != 0)
                                            <div class=" absolute flex align-center h-2 w-full {{ $this->step >= $key + 1 ? 'bg-gray-500' : 'bg-gray-200' }}  rounded items-center "
                                                style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)
                                            ">

                                            </div>
                                        @endif

                                        <div
                                            class="w-10 h-10 mx-auto {{ $this->step >= $key + 1 ? 'bg-gray-600' : 'bg-gray-300' }} rounded-full text-lg text-white flex items-center">
                                            <span
                                                class="text-center text-white w-full font-bold">{{ $key + 1 }}</span>
                                        </div>
                                    </div>

                                    <div
                                        class="text-xs text-center {{ $this->step >= $key + 1 ? 'font-bold' : '' }} ">
                                        {{ $item_name }}</div>
                                </div>

                            @endforeach
                        </div>

                    </div>

                    @if ($this->step == 1)
                        <!--dates-->

                        @include('livewire.admin.reservations.check_1_date')

                    @elseif ($this->step==2)
                        <!--rooms-->

                        @include('livewire.admin.reservations.check_2_room')

                    @elseif ($this->step==3)
                        <!--experiences-->

                        @include('livewire.admin.reservations.check_3_experience')

                    @elseif ($this->step==4)
                        <!--user-->
                        @include('livewire.admin.reservations.check_4_user')


                    @elseif ($this->step==5)

                        @include('livewire.admin.reservations.check_5_confirmation')

                    @endif
                </div>

            </x-slot>

            <x-slot name="footer">
                <div class="flex w-full justify-between">
                    @if ($this->step > 1)

                        <x-jet-button wire:loading.attr="disabled" wire:click="btn_back({{ $this->step - 1 }})"> Atras</x-jet-button>

                    @endif

                    @if ($this->step == 4)

                        <x-jet-button wire:loading.attr="disabled" wire:click="check_4_user()"> Adelante</x-jet-button>

                    @endif
                    @if ($this->step == 5)
                        <x-jet-button class="text-right" id="card-button"> Finalizar Reserva </x-jet-button>
                    @endif
                </div>

            </x-slot>
        </x-modal>
    </div>

    @include('livewire.admin.reservations.delete-reservations')
    @include('livewire.admin.reservations.details-reservations')
    @push('scripts')

        <script>
            function stripe_input() {

                var style = {
                    base: {
                        color: '#303238',
                        fontSize: '14px',
                        fontFamily: '"Open Sans", sans-serif',
                        fontSmoothing: 'antialiased',
                        '::placeholder': {
                            color: '#CFD7DF',
                        },
                    },
                    invalid: {
                        color: '#e5424d',
                        ':focus': {
                            color: '#303238',
                        },
                    },
                };
                const stripe = Stripe('{{ env('STRIPE_KEY') }}');
                const elements = stripe.elements();
                const cardElement = elements.create('card', {
                    style: style
                });

                cardElement.mount('#card-element');

                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');
                const input_error = document.getElementById('error-card-input')
                const loading_modal = document.getElementById('loading-state-modal')

                cardButton.addEventListener('click', async (e) => {

                    input_error.innerText = ""
                   
                    loading_modal.classList.remove("hidden");

                    const { paymentMethod,error } = await stripe.createPaymentMethod(
                        'card', cardElement, {
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    );

                    if (error) {
                        loading_modal.classList.add("hidden");
                        if (error.type == "validation_error") {

                            input_error.innerText = error.message

                        } else {
                            input_error.innerText = "Algo ha fallado"
                        }
                    } else {
                        @this.check_5_confirmation(paymentMethod.id)
                    }
                });
                cardElement.addEventListener('change', function(event) {
                    input_error.innerText = ""
                });

            }

        </script>
    @endpush
</div>
