@props(['disabled' => false])

<select x-data="{ country: null }" x-init="userLang = navigator.language || navigator.userLanguage;
country = userLang?.split('-')[userLang?.split('-').length - 1].toLowerCase() ?? null;
$dispatch('change', country)" x-model="country" x-modelable="country"
    {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'border-transparent border-2 focus:ring-0 focus:outline-none focus:border-secondary-500 rounded-md focus:outline-transparent bg-transparent',
    ]) !!}>
    <option class="bg-black">-</option>
    @foreach ($countries as $code => $name)
        <option class="bg-black" value="{{ $code }}">
            {{-- <x-icon name="flag-country-{{ $code }}" /> --}}
            {{ $name }}
        </option>
    @endforeach
</select>
