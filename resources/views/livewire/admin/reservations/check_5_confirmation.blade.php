<div>
    <div class=" p-4  my-8 bg-gray-100 space-y-1">
        <h2 class="text-lg mb-4 font-bold">Detalles de reserva </h2>

        <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
            <div class="text-sm font-medium text-gray-500">
                Nombre de Habitacion:
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                {{ $this->room_selected->name }}
            </div>
        </div>
        <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
            <div class="text-sm font-medium text-gray-500">
                Habitacione:
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                {{ $this->reservation->room_quantity }}
            </div>
        </div>

        <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
            <div class="text-sm font-medium text-gray-500">
                Precio por noche:
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                ${{ $this->room_selected->price }}
            </div>
        </div>
        @if ($this->reservation->days > 1)
            <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
                <div class="text-sm font-medium text-gray-500">
                    Precio por {{ $this->reservation->days }} noche(s)
                </div>
                <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                    ${{ number_format($this->room_selected->total_price_days) }}
                    <span class=" text-gray-400 text-xs">
                        ( por cada habitacion )
                    </span>
                </div>
            </div>
        @endif

        <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
            <div class="text-sm font-medium text-gray-500">
                Entrada:
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                {{ $this->reservation->start_date->format('Y-m-d') }}
            </div>
        </div>

        <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
            <div class="text-sm font-medium text-gray-500">
                Salida:
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                {{ $this->reservation->end_date->format('Y-m-d') }}
            </div>
        </div>

        <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1 ">
            <div class="text-sm font-medium text-gray-500">
                Adultos
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                {{ $this->adults }}
                @if ($this->reservation->room_quantity > 1)
                    <span class=" text-gray-400 text-xs">( por habitacion )</span>
                @endif

            </div>
        </div>

        <div class="border-b border-gray-200"></div>

        @if ($this->experience_selected)
            <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
                <div class="text-sm font-medium text-gray-500">
                    Experiencia:
                </div>
                <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                    {{ $this->experience_selected->name }}

                </div>
            </div>

            @if ($this->experience_selected->type_price == 'nigth')
                <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
                    <div class="text-sm font-medium text-gray-500">
                        Precio por noche:
                    </div>
                    <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                        {{ $this->experience_selected->price_curr }}
                        <span class=" text-gray-400 text-xs">
                            ( de cada habitacion )
                        </span>
                    </div>
                </div>
                <!--------------------------------------->
                @if ($this->reservation->days > 1)
                    <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
                        <div class="text-sm font-medium text-gray-500">
                            Precio por {{ $this->reservation->days }} noche(s)
                        </div>
                        <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                            {{ $this->experience_selected->total_price_curr}}
                        </div>
                    </div>
                @endif


            @else
                <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
                    <div class="text-sm font-medium text-gray-500">
                        Precio por reservacion:
                    </div>

                    <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                        ${{ number_format($this->experience_selected->price * $this->reservation->days) }}
                        <span class=" text-gray-400 text-xs block">
                            ( por cada habitacion )
                        </span>
                    </div>
                </div>
            @endif
        @else
            <div class=" py-1 sm:grid sm:grid-cols-3  sm:px-1">
                <div class="text-sm font-medium text-gray-500">
                    Experiencia:
                </div>
                <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                    ninguna
                </div>
            </div>
        @endif



        <div class="border-b border-gray-200"></div>
        <div class=" py-1 sm:grid sm:grid-cols-3 sm:px-1 mt-4">

            <div class="mt-1 text-lg font-bold text-gray-900 sm:mt-0 text-right sm:col-span-3 ">
                Total: <span class="ml-1">{{ $this->reservation->total_price_curr }}</span>
            </div>
        </div>
    </div>
    <div class=" p-4  my-8 bg-gray-100">
        <h2 class="text-lg mb-4 font-bold">Pago con tarjeta</h2>
        <!-- Stripe Elements Placeholder -->
        <div class="space-y-3">

            <div class="sm:w-1/2 ">
                <label for="card-holder-name" class=" mb-1 block text-sm font-medium text-gray-700">
                    Nombre del titular</label>
                <x-jet-input class=" capitalize" id="card-holder-name" type="text"
                    placeholder="como aparece en la targeta" value="{{ strtoupper($client->name) }}"></x-jet-input>
            </div>

            <div class="sm:w-2/3">
                <label for="card-holder-name" class=" mb-1 block text-sm font-medium text-gray-700">
                    Numero de Targeta</label>
                <!-- Stripe Elements Placeholder -->
                <div x-data wire:ignore x-init="
                $nextTick(() => { 
                    window.stripe_input()
                 })
                " id="card-element" class="rounded-md bg-white p-2.5 border border-gray-300">
                </div>

                <span id="error-card-input" class="error text-sm text-red-600 ml-1"></span>
                @error('card')
                    <span class="text-sm text-red-600 ml-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
