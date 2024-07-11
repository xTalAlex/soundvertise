<x-guest-layout>
    @push('head')
        @vite(['resources/js/galaxy.js'])
    @endpush

    <div class="cursor-none ">
        <canvas id="space" class="bg-black fixed h-screen w-screen inset-0 -z-10">
        </canvas>
        <div class="">
            <div class="grid grid-cols-4 mt-32 container mx-auto place-items-center gap-10">
                @foreach ($genres as $genre)
                    <a class="cursor-none" href="{{ route('planet', $genre) }}" wire:navigate>
                        <div class="py-12 w-52 planet relative hover:scale-105 transition duration-1000 ease-out"
                            style="top:{{ $genre->position_y ?? 0 }}px; left:{{ $genre->position_x ?? 0 }}px">
                            @if ($genre->icon)
                                <img class="drop-shadow-2xl" src="{{ $genre->icon }}" />
                            @else
                                <div
                                    class="shadow-2xl m-auto grid place-items-center rounded-full size-40 bg-gradient-to-br from-primary to-secondary">
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
        <a class="cursor-none" href="{{ route('home') }}">
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
</x-guest-layout>
