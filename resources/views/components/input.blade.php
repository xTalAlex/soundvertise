@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'transition duration-300 ease-in-out border-transparent border-b-secondary-500/20 border-2 focus:ring-0 focus:border-transparent focus:outline-none focus:border-b-secondary-500 focus:outline-transparent bg-transparent',
]) !!}>
