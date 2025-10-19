<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="bg-gradient-to-t from-white via-red-200 to-white dark:bg-gradient-to-t dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
    <x-navbar/>
    <main class="flex-1 flex items-center justify-center py-16 px-6">
      <div class="relative w-full max-w-5xl">
        <!-- Dekorative Farbblobs -->
        <div class="pointer-events-none absolute -inset-x-10 -top-20 transform-gpu blur-3xl opacity-30">
          <div class="bg-gradient-to-r from-red-400 via-pink-600 to-purple-700 opacity-80 rounded-full h-64 w-64 mx-auto translate-x-20" style="filter: blur(80px);"></div>
        </div>

        <section class="relative bg-white/60 dark:bg-neutral-900/60 backdrop-blur-md rounded-3xl shadow-2xl border border-white/10 p-12 md:p-16 overflow-hidden">
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

            <a href="/admin" class="w-full sm:w-auto sm:ml-auto inline-flex items-center justify-center gap-3 px-6 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-200 transition hover:shadow">
              Admin-Bereich
            </a>
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
