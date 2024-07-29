<div {{ $attributes->merge(['class' => '']) }}>
    <a class="flex items-center w-full border-2 py-2 px-4 rounded-full border-green-500 bg-green-500"
        href="{{ route('spotify.redirect') }}">
        <img src="/images/spotify_icon_white.png" class="size-5 sm:size-6" />
        <h2 class="text-wrap ms-3 text-xl font-semibold text-white">
            {{ __('Sign in with Spotify') }}
        </h2>
    </a>
</div>
