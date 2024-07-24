<nav x-data="{ open: false }">
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
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('galaxy') }}" :active="request()->routeIs('galaxy')">
                        {{ __('Galaxy') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Contacts') }}
                    </x-nav-link>
                </div>

                <x-dropdown class="relative sm:hidden" align="left" width="48">
                    <x-slot name="trigger">
                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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
                        <x-dropdown-link href="{{ route('home') }}">
                            {{ __('Contacts') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex sm:items-center sm:ms-6 place-self-end my-auto">
                <!-- Settings Dropdown -->
                @auth
                    <div class="ms-3 relative flex space-x-2">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-4 border-transparent rounded-full focus:outline-none focus:border-black-950 transition">
                                        <img class="size-12 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}

                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>


                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (auth()->user()->isAdmin())
                                    <x-dropdown-link href="{{ route('filament.admin.pages.dashboard') }}">
                                        {{ __('Admin') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>

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
                @else
                    <div class="flex justify-between space-x-2">
                        <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            {{ __('Login') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
