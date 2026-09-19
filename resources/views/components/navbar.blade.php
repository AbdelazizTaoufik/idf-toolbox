<nav class="bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 shadow-warm sticky top-0 z-40 border-b border-brand-700/40">
    <div class="flex items-center justify-between mx-auto max-w-screen-xl px-4 md:px-6 py-3">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3 rtl:space-x-reverse group">
            <img src="{{ asset('storage/images/idf-logo.png') }}"
                 class="h-10 md:h-12 rounded-md transition duration-300 ease-in-out group-hover:scale-105"
                 alt="Islamische Denkfabrik Logo" />
            <span class="hidden sm:block text-white font-extrabold tracking-tight text-lg leading-tight">
                Islamische Denkfabrik Toolbox
            </span>
        </a>

        <div class="flex items-center space-x-4">
            {{-- Desktop: Auth-Bereich (ab md sichtbar) --}}
            <div class="hidden md:flex items-center space-x-3 text-white">
                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-full transition font-semibold">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-brand-500 hover:bg-brand-400 rounded-full transition font-semibold shadow-warm">
                        Registrieren
                    </a>
                @endguest

                @auth
                    <span class="text-brand-100/90 font-medium">
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-full transition font-semibold">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>

            {{-- Mobile: Hamburger (nur auf kleinen Bildschirmen) --}}
            <button id="mobile-menu-button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-full text-white hover:bg-white/10 focus:outline-none transition"
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
        </div>
    </div>

    {{-- Mobile menu (hidden by default, sichtbar nach Toggle) --}}
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
        <div class="flex flex-col space-y-3 bg-brand-950/50 rounded-2xl p-4 text-white">
            @guest
                <a href="{{ route('login') }}"
                   class="w-full text-center px-4 py-2 bg-white/10 hover:bg-white/20 rounded-full transition font-semibold">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="w-full text-center px-4 py-2 bg-brand-500 hover:bg-brand-400 rounded-full transition font-semibold">
                    Registrieren
                </a>
            @endguest

            @auth
                <div class="font-medium text-center">
                    {{ Auth::user()->name }}
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-center px-4 py-2 bg-white/10 hover:bg-white/20 rounded-full transition font-semibold">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
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
