<div x-data="{
    genre: null,
    setGenre(data) {
        this.genre = data.id;
        $wire.dispatch('genre-selected', data);
    }
}" x-modelable="genre" {{ $attributes }}>
    <div class="relative" x-on:click.outside="open = false">
        <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-1">
            @foreach ($genres as $genre)
                <div class="relative overflow-hidden cursor-pointer p-1 group rounded-md hover:bg-primary-500/75 transition duration-300 grid place-items-center"
                    :class="{
                        'bg-primary-500': genre == {{ $genre->id }}
                    }"
                    x-on:click="setGenre({{ $genre }})">
                    @if ($genre->icon)
                        <img class="size-24 group-hover:opacity-50 group-hover:scale-150 transition duration-1000"
                            :class="{
                                'opacity-50 scale-150': genre == {{ $genre->id }},
                            }"
                            src="{{ $genre->icon }}">
                    @else
                        <div
                            class="absolute h-full grid place-items-center text-center inset-0 z-10 opacity-100 transition duration-300 text-sm font-display">
                            <div>{{ $genre->name }}</div>
                        </div>
                    @endif
                    <div class="absolute h-full grid place-items-center text-center inset-0 z-10 group-hover:opacity-100 transition duration-300 text-sm font-display"
                        :class="{
                            'opacity-100': genre == {{ $genre->id }},
                            'opacity-0': genre != {{ $genre->id }}
                        }">
                        <div>{{ $genre->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
