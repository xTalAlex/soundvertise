<x-authentication-card>
    <x-slot name="logo">

        @if ($step == 0)
            <x-authentication-card-logo />
        @else
            <ol class="text-white flex items-center w-full p-3 space-x-2 text-sm font-medium text-center shadow-sm sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse"
                x-data="{
                    step: $wire.entangle('step'),
                    totSteps: {{ $totSteps }}
                }">
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
        @endif
    </x-slot>

    <x-validation-errors class="mb-4" />

    <div x-data="{
        step: $wire.entangle('step'),
        totSteps: {{ $totSteps }}
    }">
        <div>
            @if ($step == 0)
                <x-spotify-button class="my-4 mx-auto w-fit" />
            @else
                <div x-show="step==1">

                    <div class="pt-4">
                        <x-input id="spotify_avatar" type="hidden" name="spotify_avatar"
                            wire:model="userForm.spotify_avatar" :value="old('spotify_avatar')" />
                        @if ($userForm->spotify_avatar)
                            <img src="{{ $userForm->spotify_avatar }}"
                                class="border-2 border-secondary-500 rounded-full size-20 mx-auto">
                        @endif
                    </div>

                    <div>
                        <x-input id="spotify_id" type="hidden" name="spotify_id" wire:model="userForm.spotify_id"
                            :value="old('spotify_id')" required />
                    </div>

                    <div>
                        <x-input id="spotify_name" type="hidden" name="spotify_name" wire:model="userForm.spotify_name"
                            :value="old('spotify_name')" required />
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
                        <x-country-select :detectLang="true" id="country" class="block mt-1 w-full" name="country"
                            wire:model="userForm.country" :value="old('country')" required autocomplete="country" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" required />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                            placeholder="*******" wire:model="userForm.password" required autocomplete="password" />
                        <x-input-error for="userForm.password"></x-input-error>
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" required />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" placeholder="*******"
                            wire:model="userForm.password_confirmation" required autocomplete="password" />
                        <x-input-error for="userForm.password_confirmation"></x-input-error>
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
            @endif

        </div>

        <div class="mt-8 mb-4 flex justify-center space-x-2">
            <x-button type="button" wire:click="register" wire:loading.attr="disabled" wire:target="register" x-cloak
                x-show="step==1">
                <span>{{ __('Register') }}</span>
                <span wire:loading wire:target="register"><x-loading-spinner class="ml-1 size-3" /></span>
            </x-button>
            <x-button x-cloak x-show="step==totSteps" wire:click="complete">{{ __('Complete') }}</x-button>
        </div>

    </div>
</x-authentication-card>
