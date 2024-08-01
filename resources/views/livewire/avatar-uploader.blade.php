<div x-data="{ editing: false }" class=""
    x-on:profile-editing-toggled.window="
        editing = event.detail.value;
    ">

    <div class="w-full flex items-center justify-center relative">

        <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo" />

        <div x-on:click.prevent="$refs.photo.click()" x-cloak x-show="editing"
            class="cursor-pointer rounded-full overflow-hidden border-secondary-500 border-2 mt-2 w-fit mx-auto size-40 sm:size-52 relative">
            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                class="aspect-square size-40 sm:size-52 object-cover" />
            <div class="absolute inset-0 bg-black/80 z-10" wire:loading>
                <div class="grid place-items-center h-full">
                    <x-loading-spinner class="size-6" />
                </div>
            </div>
        </div>

        <div class="mt-2 w-fit mx-auto size-40 sm:size-52 relative" x-show="!editing">
            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                class="rounded-full aspect-square size-40 sm:size-52 object-cover border-2 border-secondary-500" />
        </div>

        @if ($this->user->profile_photo_path)
            <button class="absolute z-10 text-red-500 top-2 right-0" wire:click="deleteProfilePhoto" x-cloak
                x-show="editing">
                <x-icon-close-r class="size-4" />
            </button>
        @endif

    </div>

    <x-input-error for="photo" class="mt-2 text-center mx-auto" />
</div>
