<nav class="bg-red-900 border-gray-200 m-2 rounded-2xl">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        {{-- Logo --}}
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('storage/images/idf-logo.png') }}" 
                 class="h-16 rounded-md transition duration-300 ease-in-out hover:scale-110 active:scale-90" 
                 alt="Islamische Denkfabrik Logo" />
        </a>

        {{-- Rechts: Auth-Bereich --}}
        <div class="flex items-center space-x-4 text-white">
            {{-- Wenn nicht eingeloggt --}}
            @guest
                {{-- Maybe later --}}
            @endguest

            {{-- Wenn eingeloggt --}}
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
    </div>
</nav>
