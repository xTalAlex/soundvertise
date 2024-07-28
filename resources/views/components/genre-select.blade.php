<div x-data="{
    open: false,
    genre: null,
    label: null,
    icon: null,
    setGenre(id, name, icon) {
        this.genre = id;
        this.label = name;
        this.icon = icon;
        this.open = false;
    }
}" x-modelable="genre" {{ $attributes }}>
    <div class="relative" x-on:click.outside="open = false">
        <div class="select-none cursor-pointer p-1" x-on:click="open = true">
            <div x-show="genre==null">
                {{ __('Select a genre') }} @if ($attributes->has('required'))
                    <span class="text-red-500">*</span>
                @endif
            </div>
            <div x-show="genre!=null && icon">
                <img class="size-20" x-bind:src="icon">
            </div>
            <div x-show="genre!=null && !icon" class="font-display text-xs" x-text="label">
            </div>
        </div>
        <div class="absolute bg-secondary-500 py-4 px-6 shadow-lg z-50 mt-1 w-72 md:w-96 gap-1  grid grid-cols-2 md:grid-cols-3 rounded-md"
            x-show="open" x-cloak>
            @foreach ($genres as $genre)
                <div class="cursor-pointer p-1 rounded-md hover:bg-primary-500 transition duration-200 flex flex-col items-center justify-center"
                    x-on:click="setGenre({{ $genre->id }}, '{{ $genre->name }}', '{{ $genre->icon }}')">
                    @if ($genre->icon)
                        <img class="size-10" src="{{ $genre->icon }}">
                    @endif
                    <div class="text-center text-xs font-display">{{ $genre->name }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
