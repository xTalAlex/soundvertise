@props(['disabled' => false])

{{-- Select riutilizzabile rimuovendo detectLang, x-init e x-icon --}}

@php
    $borderClasses =
        'border-2 border-transparent border-b-secondary-500/20 focus:border-transparent focus:ring-0 focus:outline-none focus:border-b-secondary-500 focus:outline-transparent ';
@endphp

<div x-data="{
    open: false,
    value: '',
    label: null,
    placeholder: '-',
    disabled: {{ $disabled ? 'true' : 'false' }},
    detectLang: {{ $detectLang ? 'true' : 'false' }},
    toggleOpen() {
        if (!this.disabled) this.open = !this.open;
    },
    setValue(value, label) {
        this.value = value;
        this.label = label;
        this.open = false;
    },
    displayedText() {
        text = this.value !== '' ? this.value : this.placeholder;
        text = this.label !== null ? this.label : text;
        return text;
    }
}" x-init="userLang = navigator.language || navigator.userLanguage;
if (detectLang) {
    value = userLang?.split('-')[userLang?.split('-').length - 1].toUpperCase() ?? null;
    var lis = $refs.selectDropdown.children;
    label = Array.from(lis).filter(li =>
        li.getAttribute('value') == value
    )[0].getAttribute('data-label');
    $dispatch('change', value);
}" x-modelable="value" {{ $disabled ? 'disabled' : '' }}
    {{ $attributes }} x-on:click.away="open = false" class="relative w-full">
    <!-- Button -->
    <button x-on:click="toggleOpen" :class="{ 'text-opacity-50': disabled || value === '' }"
        {{ $attributes->merge(['class' => 'w-full py-2 px-2 bg-transparent flex items-center justify-between ' . $borderClasses]) }}>
        <span class="w-full pr-6 overflow-hidden text-left overflow-ellipsis" x-text="displayedText"></span>
        <x-icon-keyboard-arrow-down-r class="size-4" />
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" class="absolute mt-2 bg-black-800 border-transparent border rounded-lg max-w-fit z-10" x-cloak
        x-transition>
        <ul class="rounded-lg max-h-64 overflow-auto text-white" x-ref="selectDropdown">
            <li class="transition duration-300 ease-in-out px-4 py-2 hover:bg-secondary-500 curosor-pointer"
                x-on:click="setValue('', null)" value="" x-text="placeholder"></li>
            @foreach ($values as $value => $label)
                <li class="flex items-center justify-between transition duration-300 ease-in-out px-4 py-2 hover:bg-secondary-500 cursor-pointer"
                    x-on:click="setValue('{{ $value }}','{{ $label }}')" value="{{ $value }}"
                    data-label="{{ $label }}">
                    <div>{{ $label }}</div>
                    <x-icon class="size-6" name='flag-country-{{ $value }}' />
                </li>
            @endforeach
        </ul>
    </div>
</div>
