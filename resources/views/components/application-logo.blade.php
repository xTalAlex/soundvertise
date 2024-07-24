@props(['size' => 'md'])

@php
    switch ($size) {
        case 'sm':
            $classes = 'text-lg';
            break;
        default:
            $classes = 'text-2xl sm:text-6xl';
    }
@endphp

<div {{ $attributes->merge(['class' => ' text-current font-sans uppercase font-bold tracking-tight ' . $classes]) }}
    {{ $attributes }}>
    <span @class([
        '-mr-4 sm:-mr-9' => $size == 'md',
        '-mr-4' => $size == 'sm',
    ])>SOUND</span>
    <img @class([
        'h-12 sm:h-24 inline -mt-5 sm:-mt-12' => $size == 'md',
        'h-12 inline -mt-4' => $size == 'sm',
    ]) src="/images/soundvertise_icon.png" />
    <span @class([
        '-ml-4 sm:-ml-9' => $size == 'md',
        '-ml-4' => $size == 'sm',
    ])>ERTISE</span>
</div>
