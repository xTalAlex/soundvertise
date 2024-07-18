<x-app-layout>
    @push('head')
        @vite(['resources/js/galaxy.js'])
    @endpush

    <x-slot name="header">
        {{ __('Galaxy') }}
    </x-slot>

    <div class="flex flex-col space-y-4 justify-center items-center font-bold text-white tracking-widest">
        <div class="flex flex-col md:flex-row space-x-4">
            <a href="{{ route('pairings.index') }}">
                <div
                    class="rounded-full border-2 border-white shadow-2xl w-44 text-center py-3 bg-gradient-to-r from-primary-500 to-primary-600">
                    REQUEST
                </div>
            </a>
            <a href="{{ route('pairings.index') }}">
                <div
                    class="relative border-2 border-white rounded-full shadow-2xl w-44 text-center py-3 bg-gradient-to-r from-secondary-500 to-secondary-600">
                    MATCH <div
                        class="absolute border-2 border-white text-secondary-500 -right-5 font-display  font-bold shadow-xl text-4xl -top-5 rounded-full size-10 bg-gradient-to-tr from-white to-white grid place-items-center">
                        10
                    </div>
                </div>
            </a>
        </div>
        <div
            class="rounded-full border-2 border-white shadow-2xl text-center w-44 py-3 bg-gradient-to-r from-black to-black">
            <span
                class="bg-[size:300%] animate-gradient bg-gradient-to-r from-secondary via-secondary-200 to-primary text-transparent bg-clip-text">CHOOSE
                SONG</span>
        </div>
    </div>

    <div class="">
        <canvas id="space" class="bg-black h-screen fixed w-screen inset-0 -z-10">
        </canvas>
        <div class="">
            <div class="grid grid-cols-2 md:grid-cols-4 mt-6 w-full mx-auto place-items-center">
                @foreach ($genres as $genre)
                    <a class="" href="{{ route('planet', $genre) }}" wire:navigate>
                        <div class="w-32 planet relative hover:scale-105 transition duration-1000 ease-out"
                            style="top:{{ $genre->position_y ?? 0 }}px; left:{{ $genre->position_x ?? 0 }}px">
                            @if ($genre->icon)
                                <img class="drop-shadow-2xl" src="{{ $genre->icon }}" />
                            @else
                                <div class="shadow-2xl m-auto grid place-items-center rounded-full size-20 bg-gradient-to-br from-primary to-secondary"
                                    @if ($genre->primary_color && $genre->secondary_color) style="
                                        --tw-gradient-from: {{ $genre->primary_color }} var(--tw-gradient-from-position);
                                        --tw-gradient-to: {{ $genre->secondary_color }} var(--tw-gradient-to-position);
                                    " @endif>
                                    <div class="text-white font-extrabold uppercase text-center text-sm px-4">
                                        {{ $genre->name }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <a class="" href="{{ route('home') }}">
            <div
                class="z-50 transition duration-500 grid place-items-center bg-white hover:opacity-20 rounded-full opacity-10 border-2 fixed bottom-10 size-10 inset-x-0 mx-auto">
                <div class="font-bold text-2xl">X</div>
            </div>
        </a>

        <div class="size-6 blur-sm shadow-2xl animate-pulse bg-secondary-500 fixed top-0 left-0 z-50 pointer-events-none rounded-full opacity-0 mix-blend-hue"
            id="mouse-trail">
        </div>
    </div>

    @push('bottom')
        <script type="module">
            initMouseTrail(document.getElementById("mouse-trail"));
            createSpace(document.getElementById("space"));
            //createSpace(document.getElementById("space2"));
        </script>
    @endpush
</x-app-layout>
