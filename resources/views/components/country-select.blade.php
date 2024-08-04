@props(['disabled' => false])

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
    },
    getLabelByValue(value) {
        let listItems = $refs.selectDropdown.children;
        let filteredListItems = Array.from(listItems).filter(li =>
            li.getAttribute('value') == value
        );
        if (filteredListItems.length) this.label = filteredListItems[0].getAttribute('data-label');
    }
}" x-init="userLang = navigator.language || navigator.userLanguage;
if (detectLang) {
    value = userLang?.split('-')[userLang?.split('-').length - 1].toUpperCase() ?? null;
    $dispatch('input', value)
}" x-modelable="value" {{ $disabled ? 'disabled' : '' }}
    x-effect="getLabelByValue(value)" {{ $attributes }} x-on:click.away="open = false" class="relative w-full">
    <!-- Button -->
    <button x-on:click.prevent="open = true" x-on:focus="open = true"
        :class="{ 'text-opacity-50': disabled || value === '' }"
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
            @foreach ($countries as $value => $label)
                <li class="flex items-center justify-between transition duration-300 ease-in-out px-4 py-2 hover:bg-secondary-500 cursor-pointer"
                    x-on:click="setValue('{{ $value }}','{{ $label }}')" value="{{ $value }}"
                    data-label="{{ $label }}">
                    <div>{{ $label }}</div>
                    <x-icon class="size-6" name='flag-country-{{ Str::lower($value) }}' />
                </li>
            @endforeach
        </ul>
    </div>
</div>


{{-- 

BACKUP

<select x-data="{
    country: '',
    detectLang: {{ $detectLang ? 'true' : 'false' }},
    setCountry(value) {
        this.country = value;
    }
}" x-init="userLang = navigator.language || navigator.userLanguage;
if (detectLang) {
    country = userLang?.split('-')[userLang?.split('-').length - 1].toUpperCase() ?? null;
    $dispatch('change', country);
}" x-modelable="country" {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' =>
            'border-transparent border-b-secondary-500/20 border-2 focus:ring-0 focus:outline-none focus:border-transparent focus:border-b-secondary-500 focus:outline-transparent bg-transparent',
    ]) }}
    {{ $attributes }} x-on:change="setCountry(event.target.value)">
    <option class="bg-black" value="">-</option>
    @foreach ($countries as $code => $name)
        <option class="bg-black" value="{{ $code }}">
            {{ $name }}
        </option>
    @endforeach
</select> 

--}}
