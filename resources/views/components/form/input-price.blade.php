<div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500 sm:text-sm">
            $
        </span>
    </div>
    <x-jet-input  {{ $attributes->merge(['class' => 'mb-3 pl-6 ']) }} id="price" type='number' step='0.01' placeholder="0.00" >
    </x-jet-input>

</div>