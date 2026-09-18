<x-layout title="Startseite">
    <div class="max-w-5xl mx-auto px-4 py-16 sm:py-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-200 text-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                Im Aufbau – neue Funktionen folgen laufend
            </span>

            <h1 class="mt-6 text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                IDF Toolbox
            </h1>
            <p class="mt-4 text-lg text-stone-600 dark:text-stone-300">
                Deine zentrale Anlaufstelle für Verwaltungs- und Organisationswerkzeuge der Islamischen Denkfabrik e.V.
            </p>
        </div>

        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {{-- Kummerkasten --}}
            <a href="{{ route('create.submission.view') }}"
               class="group relative bg-white dark:bg-stone-800 rounded-3xl p-6 shadow-warm hover:shadow-warm-lg hover:-translate-y-1 transition duration-300 border border-stone-100 dark:border-stone-700">
                <div class="w-12 h-12 rounded-2xl bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center text-brand-600 dark:text-brand-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-stone-900 dark:text-white">Kummerkasten</h3>
                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">Anonym Anliegen einreichen.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 dark:text-brand-300">
                    Öffnen
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
            </a>

            {{-- Wochenplan --}}
            <a href="{{ route('schedule.index') }}"
               class="group relative bg-white dark:bg-stone-800 rounded-3xl p-6 shadow-warm hover:shadow-warm-lg hover:-translate-y-1 transition duration-300 border border-stone-100 dark:border-stone-700">
                <div class="w-12 h-12 rounded-2xl bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center text-brand-600 dark:text-brand-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-stone-900 dark:text-white">Wochenplan</h3>
                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">Sitzungsgruppen der Woche im Überblick.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 dark:text-brand-300">
                    Öffnen
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
            </a>

            {{-- Bücher-Ausleihe --}}
            @if(Auth::check() && Auth::user()->hasVerifiedEmail())
            <a href="{{ route('book-loans.index') }}"
               class="group relative bg-white dark:bg-stone-800 rounded-3xl p-6 shadow-warm hover:shadow-warm-lg hover:-translate-y-1 transition duration-300 border border-stone-100 dark:border-stone-700">
                <div class="w-12 h-12 rounded-2xl bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center text-brand-600 dark:text-brand-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-stone-900 dark:text-white">Bücher-Ausleihe</h3>
                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">Bücher ausleihen und zurückgeben.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 dark:text-brand-300">
                    Öffnen
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
            </a>
            @else
            <div title="Bitte zuerst registrieren und die E-Mail-Adresse bestätigen."
                 class="relative bg-stone-50 dark:bg-stone-800/50 rounded-3xl p-6 border border-dashed border-stone-200 dark:border-stone-700 cursor-not-allowed select-none">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 dark:bg-stone-700 flex items-center justify-center text-stone-400 dark:text-stone-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-stone-400 dark:text-stone-500">Bücher-Ausleihe</h3>
                <p class="mt-1 text-sm text-stone-400 dark:text-stone-600">Registrierung & E-Mail-Bestätigung nötig.</p>
            </div>
            @endif

            {{-- Admin-Bereich --}}
            @auth
            @if(Auth::user()->is_admin)
            <a href="/admin"
               class="group relative bg-white dark:bg-stone-800 rounded-3xl p-6 shadow-warm hover:shadow-warm-lg hover:-translate-y-1 transition duration-300 border border-stone-100 dark:border-stone-700">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 dark:bg-stone-700 flex items-center justify-center text-stone-600 dark:text-stone-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-stone-900 dark:text-white">Admin-Bereich</h3>
                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">Verwaltung & Einstellungen.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-stone-600 dark:text-stone-300">
                    Öffnen
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
            </a>
            @endif
            @endauth
        </div>

        <p class="mt-14 text-center text-sm text-stone-400 dark:text-stone-500">
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-brand-400 align-middle mr-1.5 animate-pulse"></span>
            Status: In Arbeit
        </p>
    </div>
</x-layout>
