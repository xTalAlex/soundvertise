<x-guest-layout>
    <x-authentication-card transparent="true">
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <div>
            <div class="py-12">
                <x-spotify-button class="my-auto mx-auto w-fit" />
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
