<!-- Profile Photo -->
@if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
    <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
        <!-- Profile Photo File Input -->
        <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

        <div class="flex space-x-2">
            <x-label for="photo" value="{{ __('Photo') }}" />
            <button class="text-secondary-500 -mt-px text-sm" x-on:click.prevent="$refs.photo.click()">
                &#9998;
            </button>
        </div>

        <div class="">
            <div class="w-fit relative">

                <button type="button" x-on:click.prevent="$refs.photo.click()">

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                            class="rounded-full h-20 w-20 object-cover">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
                </button>


                @if ($this->user->profile_photo_path)
                    <button class="absolute z-10 text-red-500 top-0 right-0" wire:click="deleteProfilePhoto">
                        &times;
                    </button>
                @endif

            </div>
        </div>

        <x-input-error for="photo" class="mt-2" />
    </div>
@endif
