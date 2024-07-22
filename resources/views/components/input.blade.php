@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-transparent border-2 focus:ring-0 focus:border-transparent focus:outline-none focus:border-b-secondary-500 focus:outline-transparent bg-transparent',
]) !!}>
