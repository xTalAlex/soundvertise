<div class="ms-3 relative flex space-x-2">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-secondary-500 transition">
                    <img class="size-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                </button>
            @else
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black/50 bg-secondary-500 hover:text-black focus:outline-none focus:bg-secondary-50 active:bg-secondary-50 transition ease-in-out duration-150">
                        {{ Auth::user()->name }}

                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            @endif
        </x-slot>


        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-secondary-500">
                {{ __('Manage Account') }}
            </div>

            <x-dropdown-link href="{{ route('profile.show') }}">
                {{ __('Profile') }}
            </x-dropdown-link>

            <x-dropdown-link href="{{ route('profile.edit') }}">
                {{ __('Settings') }}
            </x-dropdown-link>

            @if (auth()->user()->isAdmin())
                <x-dropdown-link href="{{ route('filament.admin.pages.dashboard') }}">
                    {{ __('Admin') }}
                </x-dropdown-link>
            @endif

            <div class="border-t border-secondary-500/50"></div>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>
