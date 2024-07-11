<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <x-application-logo class="block w-auto mt-4" />

                    <h1 class="mt-8 text-2xl font-medium text-gray-900">
                        Welcome to your Jetstream application!
                    </h1>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application.
                        Laravel is
                        designed
                        to help you build your application using a development environment that is simple, powerful, and
                        enjoyable. We
                        believe
                        you should love expressing your creativity through programming, so we have spent time carefully
                        crafting the
                        Laravel
                        ecosystem to be a breath of fresh air. We hope you love it.
                    </p>
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div>
                        <div id="screenshot-container"
                            class="relative flex overflow-hidden w-full flex-1 items-stretch">
                            <img src="https://laravel.com/assets/img/welcome/docs-light.svg"
                                alt="Laravel documentation screenshot"
                                class="aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]"
                                onerror="
                    document.getElementById('screenshot-container').classList.add('!hidden');
                " />
                            <img src="https://laravel.com/assets/img/welcome/docs-dark.svg"
                                alt="Laravel documentation screenshot"
                                class="hidden aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.25)]" />

                            <div
                                class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white">
                            </div>
                        </div>

                        <div class="mt-4 text-sm">
                            <a href="https://laravel.com/docs"
                                class="inline-flex items-center font-semibold text-indigo-700">
                                Explore the documentation

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    class="ms-1 w-5 h-5 fill-indigo-500">
                                    <path fill-rule="evenodd"
                                        d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <img src="/images/spotify_icon.png" class="size-5 sm:size-6" />
                            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                <a href="{{ route('spotify.redirect') }}">Spotify</a>
                            </h2>
                        </div>

                        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                            Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development.
                            Check them
                            out,
                            see for yourself, and massively level up your development skills in the process.
                        </p>

                        <p class="mt-4 text-sm">
                            <a href="{{ route('spotify.redirect') }}"
                                class="inline-flex items-center font-semibold text-indigo-700">
                                Login

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    class="ms-1 w-5 h-5 fill-indigo-500">
                                    <path fill-rule="evenodd"
                                        d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                <a href="https://tailwindcss.com/">Tailwind</a>
                            </h2>
                        </div>

                        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                            Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that
                            doesn't get in
                            your
                            way. You'll be amazed how easily you can build and maintain fresh, modern designs with this
                            wonderful
                            framework at your fingertips.
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                Submissions
                            </h2>
                        </div>

                        <div class="mt-4 text-gray-500 text-sm leading-relaxed">
                            <ul>
                                @foreach ($submissions as $submission)
                                    <li class="flex space-x-2">
                                        <div>{{ $submission->song->name }}</div>
                                        <div>{{ $submission->playlist->name }}</div>
                                        <div>{{ $submission->created_at }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
