@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => ' rounded-md mt-1 block w-full  sm:text-sm border border-gray-300 form-input']) !!}>
