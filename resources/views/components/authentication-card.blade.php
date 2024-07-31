@props(['transparent' => false])

<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 sm:rounded-lg {{ $transparent ? '' : 'bg-white/5 shadow-md' }}">
        {{ $slot }}
    </div>
</div>
