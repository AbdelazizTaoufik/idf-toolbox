<footer class="bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 border-t border-brand-700/40">
    <div class="w-full max-w-screen-xl mx-auto px-4 md:px-6 py-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <span class="text-white font-semibold tracking-wide">
                Islamische Denkfabrik e.V.
            </span>
            <ul class="flex flex-wrap items-center gap-x-6 text-sm font-medium text-brand-100/90">
                <li>
                    <a href="{{ route('datenschutz') }}" class="hover:text-white hover:underline transition">Datenschutz</a>
                </li>
                <li>
                    <a href="{{ route('impressum') }}" class="hover:text-white hover:underline transition">Impressum</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-brand-700/40" />
        <p class="text-center text-xs text-brand-200/70">
            &copy; {{ date('Y') }} Islamische Denkfabrik e.V. Alle Rechte vorbehalten.
        </p>
    </div>
</footer>
