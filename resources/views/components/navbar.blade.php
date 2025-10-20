<nav class="bg-red-900 border-gray-200 m-2 rounded-2xl">
    <div class="flex items-center justify-between mx-auto max-w-screen-xl p-4">
        {{-- Logo --}}
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('storage/images/idf-logo.png') }}"
                 class="h-12 md:h-16 rounded-md transition duration-300 ease-in-out hover:scale-110 active:scale-90"
                 alt="Islamische Denkfabrik Logo" />
        </a>

        <div class="flex items-center space-x-4">
            {{-- Desktop: Auth-Bereich (ab md sichtbar) --}}
            <div class="hidden md:flex items-center space-x-4 text-white">
                @guest
                    {{-- evtl. Login/Register Links --}}
                @endguest

                @auth
                    <span class="text-white font-medium">
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-red-700 hover:bg-red-800 rounded-xl transition font-semibold">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>

            {{-- Mobile: Hamburger (nur auf kleinen Bildschirmen) - nur wenn eingeloggt --}}
            @auth
            <button id="mobile-menu-button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-red-800 focus:outline-none"
                    aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <!-- Hamburger Icon -->
                <svg id="icon-open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <!-- Close Icon (hidden initially) -->
                <svg id="icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            @endauth
        </div>
    </div>

    {{-- Mobile menu (hidden by default, sichtbar nach Toggle) --}}
    @auth
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
        <div class="flex flex-col space-y-3 bg-red-900 rounded-b-2xl p-4 text-white">
            {{-- evtl. Login/Register Links für Mobil (nicht nötig wenn nur für Auth) --}}

            <div class="font-medium">
                {{ Auth::user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 bg-red-700 hover:bg-red-800 rounded-xl transition font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </div>
    @endauth
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    btn && btn.addEventListener('click', function () {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!expanded));
        menu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
    });
});
</script>
