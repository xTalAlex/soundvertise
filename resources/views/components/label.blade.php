@props(['value'])

<label
    {{ $attributes->merge(['class' => 'block font-medium text-sm text-white ' . ($attributes->has('required') ? 'after:text-red-500 after:content-["*"]' : '')]) }}>
    {{ $value ?? $slot }}
</label>
