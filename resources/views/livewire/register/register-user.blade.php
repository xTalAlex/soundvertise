<x-authentication-card>
    <x-slot name="logo">
        <ol class="mb-4 text-white flex items-center w-full p-3 space-x-2 text-sm font-medium text-center shadow-sm sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse"
            x-data="{ step: 1 }">
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

    <div>
        <div>
            <form>
                <div class="-mt-10">
                    <x-input id="spotify_avatar" type="hidden" name="spotify_avatar"
                        wire:model="userForm.spotify_avatar" :value="old('spotify_avatar')" />
                    @if ($userForm->spotify_avatar)
                        <img src="{{ $userForm->spotify_avatar }}"
                            class="object-cover border-2 border-secondary-500 rounded-full size-24 mx-auto">
                    @endif
                </div>

                <div class="mt-4">
                    <x-label for="name" value="{{ __('Name') }}" required />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                        wire:model="userForm.name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error for="userForm.name" class="mt-2"></x-input-error>
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" required />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                        wire:model="userForm.email" :value="old('email')" required autocomplete="email" />
                    <x-input-error for="userForm.email" class="mt-2"></x-input-error>
                </div>

                <div class="mt-4">
                    <x-label for="country" value="{{ __('Country') }}" required />
                    <x-country-select :detectLang="true" id="country" class="block mt-1 w-full" name="country"
                        wire:model="userForm.country" :value="old('country')" required autocomplete="country" />
                    <x-input-error for="userForm.country" class="mt-2"></x-input-error>
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" required />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="*******" wire:model="userForm.password" required autocomplete="password" />
                    <x-input-error for="userForm.password" class="mt-2"></x-input-error>
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" required />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" placeholder="*******" wire:model="userForm.password_confirmation"
                        required autocomplete="password" />
                    <x-input-error for="userForm.password_confirmation" class="mt-2"></x-input-error>
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
                        <x-input-error for="terms" class="mt-2"></x-input-error>
                    </div>
                @endif

                <x-input-error for="userForm.spotify_id" class="mt-2"></x-input-error>
                <x-input-error for="userForm.spotify_name" class="mt-2"></x-input-error>
                <x-input-error for="userForm.spotify_avatar" class="mt-2"></x-input-error>
                <x-input-error for="userForm.spotify_access_token" class="mt-2"></x-input-error>
                <x-input-error for="userForm.spotify_refresh_token" class="mt-2"></x-input-error>
                <x-input-error for="userForm.spotify_token_expiration" class="mt-2"></x-input-error>
            </form>

            <div class="mt-8 mb-4 flex justify-center space-x-2">
                <x-button type="button" wire:click="register" wire:loading.attr="disabled" wire:target="register">
                    <span>{{ __('Register') }}</span>
                    <span>
                        <x-loading-spinner wire:loading wire:target="register" class="ml-1 mt-1 size-3" />
                    </span>
                </x-button>
            </div>
        </div>
    </div>
</x-authentication-card>
