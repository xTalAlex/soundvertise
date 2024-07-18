@props(['disabled' => false])

<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-primary-400 focus:bg-primary-400 active:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}
    {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>
