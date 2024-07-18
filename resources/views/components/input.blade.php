@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-white focus:border-secondary-500 focus:ring-secondary-500 rounded-md shadow-sm',
]) !!}>
