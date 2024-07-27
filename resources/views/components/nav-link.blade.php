@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'pb-2 inline-flex items-center uppercase font-bold px-1 pt-1 border-b-2 border-primary-500 text-sm leading-5 focus:outline-none focus:border-primary-500 transition duration-150 ease-in-out'
            : 'pb-2 inline-flex items-center uppercase font-bold px-1 pt-1 border-b-2 border-transparent text-sm leading-5 hover:border-secondary-500 focus:outline-none focus:border-secondary-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
