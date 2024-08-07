@props(['submit'])

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
        <form wire:submit="{{ $submit }}">
            <div
                class="px-4 py-5 bg-white/5 sm:p-6 shadow {{ isset($actions) ? 'rounded-tl-md rounded-tr-md' : 'rounded-md' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div
                    class="flex items-center justify-end px-4 py-3 bg-white/10 text-end px-6 shadow rounded-bl-md rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
