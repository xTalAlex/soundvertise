@php
    $classes = isset($title) ? 'md:grid md:grid-cols-3 md:gap-6' : '';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>

    @if (isset($title))
        <x-section-title>
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">{{ $description }}</x-slot>
        </x-section-title>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white/5 shadow sm:rounded-lg">
            {{ $content }}
        </div>
    </div>
</div>
