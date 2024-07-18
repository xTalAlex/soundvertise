<x-guest-layout>
    <div class="bg-black">
        <div
            class="h-screen bg-fixed bg-[url(https://static.wixstatic.com/media/862c6b_6263c0e2b6fb47f493a603102c1c2fb0~mv2.png/v1/fill/w_2024,h_887,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/862c6b_6263c0e2b6fb47f493a603102c1c2fb0~mv2.png)] text-white">
            <div class="flex justify-between container mx-auto max-w-5xl pt-10">
                <div class="flex flex-col items-center space-y-2 w-64">
                    {{-- <div class="mt-6">
                        <div class="text-white text-2xl uppercase font-bold tracking-tight">
                            <span class="-mr-3">SOUND</span>
                            <img class="h-10 -mt-4 inline" src="images/soundvertise_icon.png" />
                            <span class="-ml-3">ERTISE</span>
                        </div>
                    </div> --}}
                    {{-- <div class="border-r-4 border-b-4 w-min py-2 px-4 text-lg font-bold">CONTACTS</div> --}}
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Log in
                                </a>

                                {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                        Register
                                    </a>
                                @endif --}}
                            @endauth
                        </nav>
                    @endif
                    <div class="text-lg font-bold"><a href="{{ route('galaxy') }}">GALAXY</a></div>

                </div>
                <div><svg class="fill-current stroke-current h-8" viewBox="0 0 256 256" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        preserveAspectRatio="xMidYMid">
                        <g>
                            <path
                                d="M127.999746,23.06353 C162.177385,23.06353 166.225393,23.1936027 179.722476,23.8094161 C192.20235,24.3789926 198.979853,26.4642218 203.490736,28.2166477 C209.464938,30.5386501 213.729395,33.3128586 218.208268,37.7917319 C222.687141,42.2706052 225.46135,46.5350617 227.782844,52.5092638 C229.535778,57.0201472 231.621007,63.7976504 232.190584,76.277016 C232.806397,89.7746075 232.93647,93.8226147 232.93647,128.000254 C232.93647,162.177893 232.806397,166.225901 232.190584,179.722984 C231.621007,192.202858 229.535778,198.980361 227.782844,203.491244 C225.46135,209.465446 222.687141,213.729903 218.208268,218.208776 C213.729395,222.687649 209.464938,225.461858 203.490736,227.783352 C198.979853,229.536286 192.20235,231.621516 179.722476,232.191092 C166.227425,232.806905 162.179418,232.936978 127.999746,232.936978 C93.8200742,232.936978 89.772067,232.806905 76.277016,232.191092 C63.7971424,231.621516 57.0196391,229.536286 52.5092638,227.783352 C46.5345536,225.461858 42.2700971,222.687649 37.7912238,218.208776 C33.3123505,213.729903 30.538142,209.465446 28.2166477,203.491244 C26.4637138,198.980361 24.3784845,192.202858 23.808908,179.723492 C23.1930946,166.225901 23.0630219,162.177893 23.0630219,128.000254 C23.0630219,93.8226147 23.1930946,89.7746075 23.808908,76.2775241 C24.3784845,63.7976504 26.4637138,57.0201472 28.2166477,52.5092638 C30.538142,46.5350617 33.3123505,42.2706052 37.7912238,37.7917319 C42.2700971,33.3128586 46.5345536,30.5386501 52.5092638,28.2166477 C57.0196391,26.4642218 63.7971424,24.3789926 76.2765079,23.8094161 C89.7740994,23.1936027 93.8221066,23.06353 127.999746,23.06353 M127.999746,0 C93.2367791,0 88.8783247,0.147348072 75.2257637,0.770274749 C61.601148,1.39218523 52.2968794,3.55566141 44.1546281,6.72008828 C35.7374966,9.99121548 28.5992446,14.3679613 21.4833489,21.483857 C14.3674532,28.5997527 9.99070739,35.7380046 6.71958019,44.1551362 C3.55515331,52.2973875 1.39167714,61.6016561 0.769766653,75.2262718 C0.146839975,88.8783247 0,93.2372872 0,128.000254 C0,162.763221 0.146839975,167.122183 0.769766653,180.774236 C1.39167714,194.398852 3.55515331,203.703121 6.71958019,211.845372 C9.99070739,220.261995 14.3674532,227.400755 21.4833489,234.516651 C28.5992446,241.632547 35.7374966,246.009293 44.1546281,249.28042 C52.2968794,252.444847 61.601148,254.608323 75.2257637,255.230233 C88.8783247,255.85316 93.2367791,256 127.999746,256 C162.762713,256 167.121675,255.85316 180.773728,255.230233 C194.398344,254.608323 203.702613,252.444847 211.844864,249.28042 C220.261995,246.009293 227.400247,241.632547 234.516143,234.516651 C241.632039,227.400755 246.008785,220.262503 249.279912,211.845372 C252.444339,203.703121 254.607815,194.398852 255.229725,180.774236 C255.852652,167.122183 256,162.763221 256,128.000254 C256,93.2372872 255.852652,88.8783247 255.229725,75.2262718 C254.607815,61.6016561 252.444339,52.2973875 249.279912,44.1551362 C246.008785,35.7380046 241.632039,28.5997527 234.516143,21.483857 C227.400247,14.3679613 220.261995,9.99121548 211.844864,6.72008828 C203.702613,3.55566141 194.398344,1.39218523 180.773728,0.770274749 C167.121675,0.147348072 162.762713,0 127.999746,0 Z M127.999746,62.2703115 C91.698262,62.2703115 62.2698034,91.69877 62.2698034,128.000254 C62.2698034,164.301738 91.698262,193.730197 127.999746,193.730197 C164.30123,193.730197 193.729689,164.301738 193.729689,128.000254 C193.729689,91.69877 164.30123,62.2703115 127.999746,62.2703115 Z M127.999746,170.667175 C104.435741,170.667175 85.3328252,151.564259 85.3328252,128.000254 C85.3328252,104.436249 104.435741,85.3333333 127.999746,85.3333333 C151.563751,85.3333333 170.666667,104.436249 170.666667,128.000254 C170.666667,151.564259 151.563751,170.667175 127.999746,170.667175 Z M211.686338,59.6734287 C211.686338,68.1566129 204.809755,75.0337031 196.326571,75.0337031 C187.843387,75.0337031 180.966297,68.1566129 180.966297,59.6734287 C180.966297,51.1902445 187.843387,44.3136624 196.326571,44.3136624 C204.809755,44.3136624 211.686338,51.1902445 211.686338,59.6734287 Z">
                            </path>
                        </g>
                    </svg>
                </div>
                <div class="text-lg font-bold w-64">
                    <div class="">
                        <img class="w-32"
                            src="https://it.business.trustpilot.com/logos/it_new-brand-logo.svg#it_new-brand-logo-svg" />
                    </div>
                </div>
            </div>
            <div class="class grid place-items-center">
                {{-- <img class="h-28 mt-44" src="images/soundvertise_logo.png" /> --}}
                <div class="mt-32">
                    <div class="text-white text-6xl uppercase font-bold tracking-tight">
                        <span class="-mr-9">SOUND</span>
                        <img class="h-24 inline -mt-12" src="images/soundvertise_icon.png" />
                        <span class="-ml-9">ERTISE</span>
                    </div>
                </div>
                <div class="mt-5 text-xl tracking-[0.2em] font-sans font-thin">let's grow together</div>
                <div
                    class="mt-10 text-xl tracking-[0.2em] font-sans font-thin bg-[size:300%] animate-gradient bg-gradient-to-bl from-secondary via-secondary-200 to-primary text-transparent bg-clip-text">
                    artist promotion | playlist growth |
                    curators academy</div>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-t from-black to-transparent h-44 -mt-44 z-50"></div>
    <div class=" bg-black text-white pt-32">
        <div class="container max-w-5xl mx-auto px-5 relative">
            <div class="">
                <h2 class="text-6xl font-thin leading-tight">Elevate Your Music with Authentic
                    Connections</h2>
                <p class="max-w-4xl mt-5 text-3xl pr-28 leading-10 font-thin">With our expertise, we become the magnet
                    that
                    attracts the
                    ideal
                    listeners for your
                    genre. We analyze
                    your project and music to create a tailored promotion strategy, bringing your music to the right
                    ears.
                </p>

                <div class="mt-32 relative">
                    <ul
                        class="pb-10 text-5xl space-y-2 tracking-[0.2em] font-sans font-thin bg-[size:300%] animate-gradient bg-gradient-to-bl from-secondary via-secondary-200 to-primary text-transparent bg-clip-text">
                        <li>+listeners</li>
                        <li>+fans</li>
                        <li>+music</li>
                        <li>+earnings</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-64">
            <div class="container max-w-5xl mx-auto px-5 relative text-center">
                <h2 class="text-6xl font-thin leading-tight">The Art of Playlist Curation</h2>
                <p class="mt-5 text-3xl leading-10 font-thin text-center max-w-xl mx-auto">Together we will
                    create and
                    manage your playlist with active and targeted listeners for your music.
                </p>
                <div
                    class="mt-5 text-xl font-sans font-thin tracking-[0.2em] bg-[size:300%] animate-gradient bg-gradient-to-bl from-secondary via-secondary-200 to-primary text-transparent bg-clip-text">
                    artwork & videos creation | song selection | ads promotion | optimization</div>

                <div class="h-96"></div>
            </div>
        </div>
        <div class="mt-32">
            <div class="container max-w-5xl mx-auto px-5 grid grid-cols-2 gap-y-20">
                <div class="text-left">
                    <h2 class="text-5xl font-thin leading-tight">Be a part of our Network</h2>
                    <p class="mt-5 text-3xl leading-10 font-thin">
                        Soundvertise goes beyond music and playlist promotion. We're building a network where artists
                        and curators support each other, fostering career growth, lasting friendships, and creative
                        partnerships. Join us to amplify the power of music together.
                    </p>
                </div>
                <div></div>
                <div></div>
                <div class="text-right">
                    <h2 class="text-5xl font-thin leading-tight">We care about you</h2>
                    <p class="mt-5 text-3xl leading-10 font-thin">
                        We're dedicated to staying connected with all our artists, offering guidance, assistance, or
                        simply being a sounding board for ideas.
                        We have established a WhatsApp group to maintain continuous communication, providing support and
                        advice whenever it's needed!
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-64">
            <div class="container mx-auto px-5">
                <h2 class="text-6xl font-thin leading-tight mx-auto text-center">Don't trust us?
                    <br />Trust them!
                </h2>

                <div class="h-96 mt-32 bg-gradient-to-br from-primary to-secondary blur-xl"></div>
            </div>
        </div>
        <div class="mt-32">
            <div class="container mx-auto px-5">
                <h2 class="text-6xl font-thin leading-tight mx-auto text-center">
                    Talk with us
                </h2>

                <div class="grid grid-cols-2 mx-auto max-w-xl my-32 place-items-center">
                    <div>EMAIL</div>
                    <div>WHATSAPP</div>
                </div>

                <h3 class="text-2xl font-thin leading-tight mx-auto text-center">Let's schedule a free
                    videocall together!</h3>

                <div class="h-96 mx-auto w-64 mt-32 bg-gradient-to-br from-primary to-secondary blur-xl">
                    <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
                    <script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript"></script>
                    <script>
                        // Data object with Team, Event Type, and UTM info
                        var linkData = {
                            team: 'soundvertise',
                            et: 'introductory-call-let-s-meet',
                        }

                        // Tracking information object
                        var tracking = {
                            utmSource: 'Google',
                            utmMedium: 'cpc',
                            utmCampaign: 'fall_campaign',
                            utmTerm: 'soundvertise',
                            utmContent: 'logolink',
                        }

                        // Object with Customer info
                        var customer = {
                            fname: 'Nick',
                            lname: 'Smith',
                            email: 'test@test.com',
                            a1: '',
                        }

                        // Generate Dynamic Path
                        var dynamicPath = 'https://calendly.com/' + linkData.team + '/' + linkData.et;

                        // Call the Calendly Badge Widget
                        Calendly.initBadgeWidget({
                            url: dynamicPath,
                            prefill: {
                                name: customer.fname + ' ' + customer.lname,
                                email: customer.email,
                                customAnswers: {
                                    a1: customer.a1,
                                },
                                utm: {
                                    utmCampaign: tracking.utmCampaign,
                                    utmSource: tracking.utmSource,
                                    utmMedium: tracking.utmMedium,
                                    utmContent: tracking.utmContent,
                                    utmTerm: tracking.utmTerm,
                                },
                            },
                            text: 'Let\'s schedule a free videocall together!',
                            color: '#000000',
                            textColor: '#ffffff',
                            branding: false
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="mt-64 pb-32">
            <div class="w-fit mx-auto">
                <div class="text-white text-2xl uppercase font-bold tracking-tight">
                    <span class="-mr-3">SOUND</span>
                    <img class="h-10 -mt-4 inline" src="images/soundvertise_icon.png" />
                    <span class="-ml-3">ERTISE</span>
                </div>
            </div>
        </div>
</x-guest-layout>
