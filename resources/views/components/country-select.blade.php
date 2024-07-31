@props(['disabled' => false])

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
            'border-transparent border-2 focus:ring-0 focus:outline-none focus:border-secondary-500 rounded-md focus:outline-transparent bg-transparent',
    ]) }}
    {{ $attributes }} x-on:change="setCountry(event.target.value)">
    <option class="bg-black" value="">-</option>
    @foreach ($countries as $code => $name)
        <option class="bg-black" value="{{ $code }}">
            {{-- <x-icon name='flag-country-{{ $code }}' /> --}}
            {{ $name }}
        </option>
    @endforeach
</select>
