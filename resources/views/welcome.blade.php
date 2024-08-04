<x-app-layout hero="true">
    <div class="bg-black">
        <div
            class="h-screen bg-fixed bg-[url(https://static.wixstatic.com/media/862c6b_6263c0e2b6fb47f493a603102c1c2fb0~mv2.png/v1/fill/w_2024,h_887,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/862c6b_6263c0e2b6fb47f493a603102c1c2fb0~mv2.png)] text-white">
            <div class="pt-10 class grid place-items-center">
                {{-- <img class="h-28 mt-44" src="images/soundvertise_logo.png" /> --}}
                <x-application-logo class="mt-32" />
                <div class="mt-5 text-xl tracking-[0.2em] font-sans font-thin">let's grow together</div>
                <div
                    class="mt-10 hidden sm:block tracking-[0.2em] font-sans font-thin bg-[size:300%] animate-gradient bg-gradient-to-bl from-secondary via-secondary-200 to-primary text-transparent bg-clip-text">
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
</x-app-layout>
