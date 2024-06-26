<x-guest-layout>
    @push('head-scripts')
        @vite(['resources/js/galaxy.js'])
    @endpush

    <canvas id="space" class="fixed h-screen w-screen inset-0 -z-10">
    </canvas>
    <div>
        <div class="grid grid-cols-4 mt-32 container mx-auto">
            @foreach ($genres as $genre)
                <div class="w-52 relative"
                    style="top:{{ $genre->position_y ?? 0 }}px; left:{{ $genre->position_x ?? 0 }}px">
                    @if ($genre->icon)
                        <img src="{{ $genre->icon }}" />
                    @else
                        <div class="rounded-full size-40 bg-gradient-to-br from-primary to-secondary"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    @push('bottom-scripts')
        <script type="module">
            createSpace(document.getElementById("space"));
            //createSpace(document.getElementById("space2"));
            //initMouseTrail(document.getElementById("mouse-trail"));
        </script>
    @endpush
</x-guest-layout>
