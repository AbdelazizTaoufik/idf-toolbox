

<footer class="bg-gradient-to-r from-red-950 via-red-900 to-red-950 border-t border-red-800/50">
    <div class="w-full max-w-screen-xl mx-auto px-4 md:px-6 py-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <span class="text-white font-semibold tracking-wide">
                Islamische Denkfabrik e.V.
            </span>
            <ul class="flex flex-wrap items-center gap-x-6 text-sm font-medium text-red-100">
                <li>
                    <a href="{{ route('datenschutz') }}" class="hover:text-white hover:underline transition">Datenschutz</a>
                </li>
                <li>
                    <a href="{{ route('impressum') }}" class="hover:text-white hover:underline transition">Impressum</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-red-800/60" />
        <p class="text-center text-xs text-red-200/80">
            &copy; {{ date('Y') }} Islamische Denkfabrik e.V. Alle Rechte vorbehalten.
        </p>
    </div>
</footer>

