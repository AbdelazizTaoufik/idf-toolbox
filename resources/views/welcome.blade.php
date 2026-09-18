<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
    <x-navbar/>
    <main class="flex-1 flex items-center justify-center py-16 px-3">
      <div class="relative w-full max-w-5xl">

        <section class="relative bg-white/60 dark:bg-neutral-900/60 backdrop-blur-md rounded-3xl shadow-2xl border border-white/10 p-6 md:p-16 overflow-hidden">
          <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400 drop-shadow-lg">
            IDF Toolbox
          </h1>
          <p class="mt-4 text-lg sm:text-xl text-neutral-700 dark:text-neutral-300 max-w-2xl">
            Willkommen bei der IDF Toolbox – deiner zentralen Anlaufstelle für Verwaltungs- und Organisationswerkzeuge der Islamischen Denkfabrik e.V. Das Projekt befindet sich noch im Aufbau, doch der digitale anonyme Kummerkasten ist bereits einsatzbereit. In Zukunft werden nach und nach weitere nützliche und spannende Funktionen ergänzt.
          </p>

          <div class="mt-8 flex flex-col sm:flex-row sm:items-center gap-4">
            <a href="{{ route('create.submission.view') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-3 rounded-lg bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition">
              Kummerkasten
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <a href="{{ route('schedule.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-3 rounded-lg border border-red-300 dark:border-red-800 text-red-700 dark:text-red-300 font-semibold hover:bg-red-50 dark:hover:bg-red-950 transition">
              Wochenplan
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </a>

            @if(Auth::check() && Auth::user()->hasVerifiedEmail())
            <a href="{{ route('book-loans.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-3 rounded-lg border border-red-300 dark:border-red-800 text-red-700 dark:text-red-300 font-semibold hover:bg-red-50 dark:hover:bg-red-950 transition">
              Bücher-Ausleihe
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </a>
            @else
            <span title="Bitte zuerst registrieren und die E-Mail-Adresse bestätigen." class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-400 dark:text-neutral-600 font-semibold cursor-not-allowed select-none">
              Bücher-Ausleihe
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </span>
            @endif

            @auth
            @if(Auth::user()->is_admin)
            <a href="/admin" class="w-full sm:w-auto sm:ml-auto inline-flex items-center justify-center gap-3 px-6 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-200 transition hover:shadow">
              Admin-Bereich
            </a>
            @endif
            @endauth
          </div>

          <div class="mt-10">
            <div class="rounded-xl border border-neutral-100 dark:border-neutral-800 bg-white/80 dark:bg-neutral-900/50 p-6">
              <p class="text-neutral-600 dark:text-neutral-300">Status: In Arbeit <span class="ml-2 inline-block animate-pulse">●</span></p>
            </div>
          </div>
        </section>
      </div>
    </main>
    <x-footer/>
  </body>
</html>
