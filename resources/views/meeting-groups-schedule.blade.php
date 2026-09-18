<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Wochenplan</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
        <x-navbar/>

        <main class="flex-1 py-12 px-4">
            <div class="max-w-screen-xl mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400 drop-shadow-lg">
                        Wochenplan
                    </h1>
                    <p class="mt-4 text-lg text-neutral-700 dark:text-neutral-300 max-w-2xl mx-auto">
                        Übersicht aller öffentlichen Sitzungsgruppen der Islamischen Denkfabrik e.V.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-4">
                    @foreach($weekdays as $key => $label)
                        <div class="bg-white/70 dark:bg-neutral-900/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/10 overflow-hidden flex flex-col">
                            <div class="bg-red-900 text-white text-center font-semibold py-3">
                                {{ $label }}
                            </div>
                            <div class="p-3 flex-1 flex flex-col gap-3">
                                @forelse($meetingGroups->get($key, collect()) as $group)
                                    <div class="rounded-xl bg-red-50 dark:bg-red-950/50 border border-red-100 dark:border-red-900 p-3">
                                        @if($group->time)
                                            <p class="text-sm font-bold text-red-700 dark:text-red-300">{{ $group->time->format('H:i') }} Uhr</p>
                                        @endif
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $group->name }}</p>
                                        @if($group->description)
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $group->description }}</p>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 dark:text-gray-500 text-center italic my-auto">Keine Termine</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($meetingGroups->get('', collect())->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ohne festen Wochentag</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($meetingGroups->get('', collect()) as $group)
                                <div class="rounded-xl bg-white/70 dark:bg-neutral-900/60 backdrop-blur-md shadow-lg border border-white/10 p-4">
                                    @if($group->time)
                                        <p class="text-sm font-bold text-red-700 dark:text-red-300">{{ $group->time->format('H:i') }} Uhr</p>
                                    @endif
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $group->name }}</p>
                                    @if($group->description)
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $group->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($meetingGroups->isEmpty())
                    <p class="text-center text-neutral-600 dark:text-neutral-300 mt-10">
                        Aktuell sind keine öffentlichen Sitzungsgruppen eingetragen.
                    </p>
                @endif
            </div>
        </main>

        <x-footer/>
    </body>
</html>
