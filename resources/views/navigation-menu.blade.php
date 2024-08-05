<nav @class(['absolute inset-x-0 top-0' => $transparent]) x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  mt-4 sm:mt-12">
        <div class="grid grid-cols-2 w-full place-items-center">
            <div class="flex flex-col items-center space-y-2 place-self-start">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="hidden sm:block" size="sm" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex justify-between space-x-2">
                    {{-- <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('galaxy') }}" :active="request()->routeIs('galaxy')">
                        {{ __('Galaxy') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Contacts') }}
                    </x-nav-link> --}}
                    <a class="group flex items-center" href="{{ route('galaxy') }}">
                        <div @class([
                            'pb-1 group-hover:border-secondary-500 transition duration-300 ease-in-out group-focus:outline-none border-transparent pt-1 px-1 font-bold uppercase animated-gradient-text',
                        ])>
                            {{ __('Galaxy') }}
                        </div>
                        <div @class([
                            '-ml-1 font-bold cursor-pointer inline-block text-secondary-500 group-hover:text-primary-500 group-hover:translate-x-px transition duration-1000 ease-in-out',
                            'hidden' => request()->routeIs('galaxy'),
                        ])>
                            <x-icon-play-arrow-r class="mt-0.5 size-4" />
                        </div>
                    </a>
                </div>

                <x-dropdown class="relative sm:hidden" align="left" width="48">
                    <x-slot name="trigger">
                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-secondary-500 focus:outline-none focus:text-secondary-500 transition duration-300 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('home') }}">
                            {{ __('Home') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('galaxy') }}">
                            {{ __('Galaxy') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex sm:items-center sm:ms-6 place-self-end my-auto">
                <!-- User Dropdown -->
                @auth
                    @if (auth()->user()->isAdmin())
                        <a class="hover:text-secondary-500 transition duraiton-300 ease-in-ou"
                            href="{{ route('filament.admin.pages.dashboard') }}">
                            <x-icon-theater-comedy-r class="size-10 t" data-tippy-content="{{ __('Admin') }}" />
                        </a>
                    @endif
                    <div>
                        <a class="ms-3 relative flex space-x-2" href="{{ route('profile.show') }}">
                            <div @class([
                                'flex text-sm border-2 rounded-full focus:outline-none focus:border-secondary-500 transition',
                                request()->routeIs('profile.show') || request()->routeIs('profile.edit')
                                    ? 'border-secondary-500'
                                    : 'border-transparent',
                            ])>
                                <img class="size-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                    alt="{{ Auth::user()->name }}" />
                            </div>
                        </a>
                    </div>
                @else
                    <div class="flex justify-between space-x-2">
                        <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            {{ __('Login') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
