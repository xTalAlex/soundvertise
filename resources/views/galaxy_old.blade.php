<x-guest-layout>
    @push('head-scripts')
        <script src="https://cdn.jsdelivr.net/npm/pushin@6/dist/umd/pushin.min.js"></script>
    @endpush

    <div class="relative h-screen bg-black " id="galaxy-container">
        <div class="pushin text-white " x-data="{
            curPlanet: null,
            togglePlanet(event, id) {
                this.curPlanet = id;
                var elements = document.getElementsByClassName('orbit');
                var elementsLength = elements.length - 1;
                for (var i = 0; i <= elementsLength; i++) {
                    if (this.curPlanet) {
                        elements[i].classList.contains('opacity-0') ? elements[i].classList.remove('opacity-0', 'blur-sm') : elements[i].classList.add('opacity-0', 'blur-sm');
                    } else elements[i].classList.add('opacity-0', 'blur-sm');
                }
                if (this.curPlanet) {
                    setTimeout(function() { window.location = '#planet' + id; }, 700);
                } else {
                    window.location = '#galaxy';
                }
            },
        
        }">
            <div class="pushin-layer relative" id="galaxy">
                <div class="">
                    <canvas id="space" class="fixed inset-0 -z-10 transition-all duration-500"
                        :class="curPlanet == null ? '' : 'opacity-0'">
                    </canvas>
                    <h1 class="font-bold text-2xl text-center ">GALAXY</h1>
                    <div class="space-x-6 text-lg uppercase mt-12 grid grid-cols-3">
                        <div class="transform transition-all duration-500  shadow-xl font-extrabold cursor-pointer"
                            x-on:click="togglePlanet(event, 1)">
                            <div :class="{
                                'scale-0 opacity-0 blur-xl translate-y-1/2 -translate-x-20': curPlanet && curPlanet !=
                                    1,
                                'scale-125 opacity-0 blur-sm -translate-y-2 delay-100 translate-x-5': curPlanet == 1
                            }"
                                class="size-44 z-10 transition-all shadow-2xl duration-1000 ease-out rounded-full bg-gradient-to-r to-90% grid place-items-center from-green-500 to-yellow-500">
                                <h2 class="text-2xl uppercase ">
                                    Rock</h2>
                            </div>
                        </div>
                        <div class="transform transition-all duration-500  shadow-xl font-extrabold cursor-pointer"
                            x-on:click="togglePlanet(event,2)">
                            <div :class="{
                                'scale-0 opacity-0 blur-xl translate-y-1/2': curPlanet && curPlanet != 2,
                                'scale-125 opacity-0 blur-sm -translate-y-2 delay-100': curPlanet == 2
                            }"
                                class="size-44 z-10 transition-all shadow-2xl duration-1000 ease-out rounded-full bg-gradient-to-r to-90% grid place-items-center from-blue-500 to-yellow-500">
                                <h2 class="text-2xl uppercase ">
                                    Pop</h2>
                            </div>
                        </div>
                        <div class="transform transition-all duration-500  shadow-xl font-extrabold cursor-pointer"
                            x-on:click="togglePlanet(event,3)">
                            <div :class="{
                                'scale-0 opacity-0 blur-xl translate-y-1/2 translate-x-20': curPlanet && curPlanet != 3,
                                'scale-125 opacity-0 blur-sm -translate-y-2 delay-100 -translate-x-5': curPlanet == 3
                            }"
                                class="size-44 z-10 transition-all shadow-2xl duration-1000 ease-out rounded-full bg-gradient-to-r to-90% grid place-items-center from-pink-500 to-yellow-500">
                                <h2 class="text-2xl uppercase ">
                                    Piano</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="space2" class="fixed inset-0 -z-10 transition-all duration-500"
                :class="curPlanet == null ? 'opacity-0' : ''">
            </canvas>
            <div class="pushin-layer planet transition duration-500" id="planet1">
                <div :class="curPlanet == 1 ? 'opacity-1 blur-0' : 'opacity-0 blur-sm'"
                    class="size-44 z-10 transition-all shadow-2xl duration-1000 delay-400 ease-out rounded-full bg-gradient-to-r to-90% grid place-items-center from-green-500 to-yellow-500">
                    <h2 class="text-2xl uppercase ">
                        Rock</h2>
                </div>
                <div class="uppercase font-bold text-xs mt-12 z-50 text-violet-500"><a href="#galaxy"
                        x-on:click="togglePlanet(null)">back</a>
                </div>
            </div>
            <div class="pushin-layer planet transition duration-500" id="planet2">
                <div :class="curPlanet == 2 ? 'opacity-1 blur-0' : 'opacity-0 blur-sm'"
                    class="size-44 z-10 transition-all shadow-2xl duration-1000 delay-400 ease-out rounded-full bg-gradient-to-r to-90% grid place-items-center from-blue-500 to-yellow-500">
                    <h2 class="text-2xl uppercase ">
                        Pop</h2>
                </div>
                <div class="uppercase font-bold text-xs mt-12 z-50 text-violet-500"><a href="#galaxy"
                        x-on:click="togglePlanet(null)">back</a>
                </div>
            </div>
            <div class="pushin-layer planet transition duration-500" id="planet3">
                <div :class="curPlanet == 3 ? 'opacity-1 blur-0' : 'opacity-0 blur-sm'"
                    class="size-44 z-10 transition-all shadow-2xl duration-1000 delay-400 ease-out rounded-full bg-gradient-to-r to-90% grid place-items-center from-pink-500 to-yellow-500">
                    <h2 class="text-2xl uppercase ">
                        Piano</h2>
                </div>
                <div class="uppercase font-bold text-xs mt-12 z-50 text-violet-500"><a href="#galaxy"
                        x-on:click="togglePlanet(null)">back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="size-6 blur-sm shadow-2xl animate-pulse bg-emerald-500  bg-violet-500 fixed top-0 left-0 z-50 pointer-events-none rounded-full opacity-0 mix-blend-hue"
        id="mouse-trail">
    </div>;

    @push('bottom-scripts')
        <script>
            function createDot(x, y, planetId) {
                var elem = document.createElement("div");
                var colors = [
                    "from-red-500 to-yellow-500",
                    "from-green-500 to-yellow-500",
                    "from-blue-500 to-yellow-500",
                    "from-pink-500 to-yellow-500",
                    "from-gray-500 to-yellow-500",
                    "to-red-500 from-violet-500",
                    "to-green-500 from-violet-500",
                    "to-blue-500 from-violet-500",
                    "to-pink-500 from-violet-500",
                    "to-gray-500 from-violet-500",
                ];
                const sizes = [
                    "size-2",
                    "size-3",
                    "size-4",
                    "size-5",
                    "size-6",
                ]
                const delays = [
                    "delay-700",
                    "delay-1000",
                    "delay-[1200ms]",
                    "delay-[1400ms]"
                ]
                const durations = [
                    "duration-500",
                    "duration-700",
                    "duration-1000",
                    "duration-[2000ms]"
                ]
                elem.setAttribute(
                    "class",
                    `absolute orbit animate-floating shadow-2xl hover:shadow-inner cursor-pointer blur-sm ${sizes[Math.floor(Math.random()*sizes.length)]} opacity-0  transition-all transform ${durations[Math.floor(Math.random()*durations.length)]} ${delays[Math.floor(Math.random()*delays.length)]} rounded-full bg-gradient-to-r z-50 ${colors[(planetId) % colors.length]}`

                );
                elem.setAttribute("style", "left:" + x + "px;top:" + y + "px;");
                document.getElementById(`planet${planetId}`).appendChild(elem);
                return elem;
            }

            function anotherDot(planetId) {
                createDot(
                    Math.floor(Math.random() * (screen.width)),
                    Math.floor(Math.random() * (screen.height)),
                    planetId
                );
            }

            var nGroups = document.getElementsByClassName('planet').length;
            var groupSize = 60;
            for (var i = 0; i < groupSize * nGroups; i++) {
                anotherDot(Math.floor(i / groupSize) + 1);
            }

            const container = document.querySelector('.pushin');
            new pushin.PushIn(container, {}).start();
        </script>
        @vite(['resources/js/animatebg.js', 'resources/js/mousetrail.js'])
    @endpush

</x-guest-layout>
