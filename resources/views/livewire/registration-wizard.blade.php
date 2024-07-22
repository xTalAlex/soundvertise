<x-authentication-card>
    <x-slot name="logo">
        <ol class="text-white flex items-center w-full p-3 space-x-2 text-sm font-medium text-center shadow-sm sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse"
            x-data="{
                step: $wire.entangle('step'),
                totSteps: 1
            }" x-init="totSteps = $refs.ol.childElementCount;" x-ref="ol">
            <li class="flex items-center" x-bind:class="step == 1 ? 'text-primary-500' : ''">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0"
                    x-bind:class="step == 1 ?
                        'border-primary-500' :
                        'border-current '">
                    1
                </span>
                User <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center" x-bind:class="step == 2 ? 'text-primary-500' : ''">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0"
                    x-bind:class="step == 2 ?
                        'border-primary-500' :
                        'border-current '">
                    2
                </span>
                Playlists <span class="hidden sm:inline-flex sm:ms-2">Info</span>
            </li>
        </ol>
    </x-slot>

    <x-validation-errors class="mb-4" />

    <div x-data="{
        step: $wire.entangle('step'),
        totSteps: 1
    }" x-init="totSteps = $refs.stepsContainer.childElementCount;">
        <div x-ref="stepsContainer">
            <div x-cloak x-show="step==1">

                <div>
                    <x-input id="spotify_id" type="hidden" name="spotify_id" wire:model="userForm.spotify_id"
                        :value="old('spotify_id')" required />
                </div>

                <div>
                    <x-input id="spotify_name" type="hidden" name="spotify_name" wire:model="userForm.spotify_name"
                        :value="old('spotify_name')" required />
                </div>

                <div class="pt-4">
                    <x-input id="spotify_avatar" type="hidden" name="spotify_avatar"
                        wire:model="userForm.spotify_avatar" :value="old('spotify_avatar')" />
                    @if ($userForm->spotify_avatar)
                        <img src="{{ $userForm->spotify_avatar }}"
                            class="border-2 border-secondary-500 rounded-full size-20 mx-auto">
                    @endif
                </div>

                <div class="mt-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                        wire:model="userForm.name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                        wire:model="userForm.email" :value="old('email')" required autocomplete="email" />
                </div>

                <div class="mt-4">
                    <x-label for="country" value="{{ __('Country') }}" />
                    <x-country-select id="country" class="block mt-1 w-full" name="country"
                        wire:model="userForm.country" :value="old('country')" required autocomplete="country" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" required />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="*******" wire:model="userForm.password" required autocomplete="password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" required />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" placeholder="*******" wire:model="userForm.password_confirmation"
                        required autocomplete="password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                            '<a target="_blank" href="' .
                                            route('terms.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            __('Terms of Service') .
                                            '</a>',
                                        'privacy_policy' =>
                                            '<a target="_blank" href="' .
                                            route('policy.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            __('Privacy Policy') .
                                            '</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif
            </div>

            <div x-cloak x-show="step==2">

                <div>
                    <div class="flex" x-data="{
                        open: true,
                        newPlaylistUrl: $wire.entangle('newPlaylistUrl'),
                        setNewPlaylistUrl(url) {
                            this.newPlaylistUrl = url;
                            this.open = false;
                        }
                    }" x-on:click.outside="open = false"
                        wire:init="fetchPlaylists">
                        <div class="w-full relative">
                            <div class="relative w-full mt-1">
                                <x-input id="newPlaylistUrl" class="block w-full overflow-ellipsis" type="text"
                                    name="newPlaylistUrl" wire:model="newPlaylistUrl" :value="old('newPlaylistUrl')" required
                                    autofocus placeholder="{{ __('Insert your playlist URL') }}"
                                    autocomplete="newPlaylistUrl" x-on:focus="open = true" />
                            </div>
                            <div class="absolute z-50 w-full bg-black shadow-lg mt-1 rounded-md py-4 px-6" x-cloak
                                x-show="open">
                                <div class="mb-6 select-none text-sm opacity-50">{{ __('Your most recent playlists') }}
                                </div>
                                <div class="w-full" wire:loading wire:target="fetchPlaylists">
                                    <div class="w-fit mx-auto">
                                        <x-loading-spinner />
                                    </div>
                                </div>
                                <div wire:loading.remove wire:target="fetchPlaylists"
                                    class="space-y-1 max-h-64 overflow-y-auto">
                                    @forelse ($fetchedPlaylists->filter(fn($playlist) => !$this->playlists->contains('spotify_id',$playlist['id']) ) as $playlist)
                                        <div class="flex space-x-2 cursor-pointer hover:bg-primary-500 rounded-md transition duration-200 p-1 items-center"
                                            x-on:click="setNewPlaylistUrl('{{ $playlist['external_urls']['spotify'] ?? $playlist['id'] }}')">
                                            <img class="object-cover aspect-square size-12"
                                                src="{{ $playlist['images'][0]['url'] }}" />
                                            <div>{{ $playlist['name'] }}</div>
                                        </div>
                                    @empty
                                        <div class="select-none opacity-50 text-center">
                                            {{ __('No playlists found') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <x-button wire:click="fetchPlaylist" wire:loading.disabled wire:target="fetchPlaylist"
                            x-bind:disabled="newPlaylistUrl.trim() == ''">{{ __('Add') }}</x-button>
                    </div>
                </div>

                <div class="w-full mt-8 min-h-64">
                    @if (count($playlists))
                        <div class="space-y-2">
                            @forelse($playlists as $key => $playlist)
                                <div>
                                    <div class="flex flex-col sm:flex-row justify-between items-center space-x-2">
                                        <div class="flex items-center flex-grow space-x-2 relative">
                                            <div class="hidden">
                                                <x-input id="playlists.{{ $key }}.spotify_user_id"
                                                    type="hidden"
                                                    name="playlists.{{ $key }}.spotify_user_id"
                                                    wire:model="playlists.{{ $key }}.spotify_user_id"
                                                    :value="old('playlists.{{ $key }}.spotify_user_id')" required />
                                                <x-input id="playlists.{{ $key }}.spotify_id" type="hidden"
                                                    name="playlists.{{ $key }}.spotify_id"
                                                    wire:model="playlists.{{ $key }}.spotify_id"
                                                    :value="old('playlists.{{ $key }}.spotify_id')" required />
                                                <x-input id="playlists.{{ $key }}.url" type="hidden"
                                                    name="playlists.{{ $key }}.url"
                                                    wire:model="playlists.{{ $key }}.url"
                                                    :value="old('playlists.{{ $key }}.url')" />
                                                <x-input id="playlists.{{ $key }}.name" type="hidden"
                                                    name="playlists.{{ $key }}.name"
                                                    wire:model="playlists.{{ $key }}.name" :value="old('playlists.{{ $key }}.name')"
                                                    required />
                                                <x-input id="playlists.{{ $key }}.description"
                                                    type="hidden" name="playlists.{{ $key }}.description"
                                                    wire:model="playlists.{{ $key }}.description"
                                                    :value="old('playlists.{{ $key }}.description')" />
                                                <x-input id="playlists.{{ $key }}.collaborative"
                                                    type="hidden" name="playlists.{{ $key }}.collaborative"
                                                    wire:model="playlists.{{ $key }}.collaborative"
                                                    :value="old('playlists.{{ $key }}.collaborative')" />
                                                <x-input id="playlists.{{ $key }}.followers_total"
                                                    type="hidden"
                                                    name="playlists.{{ $key }}.followers_total"
                                                    wire:model="playlists.{{ $key }}.followers_total"
                                                    :value="old('playlists.{{ $key }}.followers_total')" required />
                                                <x-input id="playlists.{{ $key }}.tracks_total"
                                                    type="hidden" name="playlists.{{ $key }}.tracks_total"
                                                    wire:model="playlists.{{ $key }}.tracks_total"
                                                    :value="old('playlists.{{ $key }}.tracks_total')" required />
                                            </div>
                                            <img class="object-cover aspect-square size-12"
                                                src="{{ $playlist['image'] }}" />
                                            <div class="cursor-default">{{ $playlist['name'] }}
                                                <button class="inline-block text-red-500 size-4"
                                                    wire:click="removePlaylist('{{ $playlist['spotify_id'] }}')"
                                                    wire:loading.disabled wire:target="removePlaylist">&times;</button>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 items-center">
                                            <x-genre-select name="playlists.{{ $key }}.genre_id"
                                                wire:model="playlists.{{ $key }}.genre_id" :value="old('playlists.{{ $key }}.genre_id')"
                                                required />
                                            <x-button x-on:click="alert('NON È IL MOMENTO!!!!');">
                                                <span>&#128206;</span>
                                                <span class="text-red-500 w-0 -mt-px">
                                                    *
                                                </span>
                                            </x-button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @else
                        <div>

                        </div>
                    @endif
                    <div class="w-full my-4" wire:loading wire:target="fetchPlaylist">
                        <div class="w-fit mx-auto">
                            <x-loading-spinner />
                        </div>
                    </div>


                    @if ($playlists->count())
                        <div class="w-fit mx-auto opacity-50 mt-8 text-sm">{{ $playlists->count() }} /
                            {{ config('soundvertise.register.max_playlists') }}
                        </div>
                    @endif

                </div>
            </div>

        </div>

        <div class="mt-8 mb-4 flex justify-center space-x-2">
            <x-button x-cloak x-show="step!=1" wire:click="previousStep">{{ __('Back') }}</x-button>
            <x-button x-cloak x-show="step!=totSteps" wire:click="nextStep">{{ __('Next') }}</x-button>
            @if (count($playlists))
                <div>
                    <x-button type="button" wire:click="register" x-cloak x-show="step==totSteps"
                        wire:loading.disabled wire:taget="register">
                        <span>{{ __('Register') }}</span>
                        <span wire:loading wire:target="register"><x-loading-spinner class="ml-1 size-3" /></span>
                    </x-button>
                </div>
            @endif
        </div>

    </div>
</x-authentication-card>
