<div>
    <div class="px-3">
       
            <h2 class=" text-xl">Experiencias</h2>
            <div class=" text-right  py-4">
                <a href="#!" wire:click="check_3_experience()" class=" text-blue-600">
                    Seguir sin experiencia
                </a>
            </div>
            @if ($this->experiences_availables)
            <div class=" text-sm rounded-md  text-gray-600 bg-white divide-y divide-gray-300 space-y-3">
                @foreach ($this->experiences_availables as $exp)
                    <div wire:key="experience_{{ $exp->id }}" class="flex justify-between text-gray-700  ">

                        <div class="flex flex-col flex-grow py-3">
                            <p class=" text-base font-bold">{{ $exp->name }} </p>
                            @if ($exp->type_price == 'nigth')
                                <p>
                                    por noche: <b>{{ $exp->price_curr }}</b> 
                                </p>
                                @if ($this->reservation->days > 1)
                                    <p>
                                        por {{ $this->reservation->days }} dias:
                                        <b>{{ $exp->total_price_curr }}</b>
                                        
                                    </p>
                                @endif
                            @else
                                <p>
                                    por reservacion: <b>{{ $exp->price_curr }}</b> 
                                </p>
                            @endif
                        </div>
                        <div class="self-end ">

                            <x-jet-button wire:click="check_3_experience({{ $exp->id }})">
                                Seleccionar
                            </x-jet-button>
                        </div>
                    </div>
                @endforeach

            </div>
            @endif
    </div>
</div>
