<x-layout title="Wochenplan">
    <div class="max-w-screen-xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                Wochenplan
            </h1>
            <p class="mt-4 text-lg text-stone-600 dark:text-stone-300 max-w-2xl mx-auto">
                Übersicht aller öffentlichen Sitzungsgruppen der Islamischen Denkfabrik e.V.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-4">
            @foreach($weekdays as $key => $label)
                <div class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 overflow-hidden flex flex-col">
                    <div class="bg-brand-600 text-white text-center font-semibold py-3">
                        {{ $label }}
                    </div>
                    <div class="p-3 flex-1 flex flex-col gap-3">
                        @forelse($meetingGroups->get($key, collect()) as $group)
                            <div class="rounded-2xl bg-brand-50 dark:bg-brand-900/30 border border-brand-100 dark:border-brand-900 p-3">
                                @if($group->time)
                                    <p class="text-sm font-bold text-brand-700 dark:text-brand-300">{{ $group->time->format('H:i') }} Uhr</p>
                                @endif
                                <p class="font-semibold text-stone-900 dark:text-white">{{ $group->name }}</p>
                                @if($group->description)
                                    <p class="text-xs text-stone-600 dark:text-stone-400 mt-1">{{ $group->description }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-stone-400 dark:text-stone-500 text-center italic my-auto">Keine Termine</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        @if($meetingGroups->get('', collect())->isNotEmpty())
            <div class="mt-10">
                <h2 class="text-xl font-bold text-stone-900 dark:text-white mb-4">Ohne festen Wochentag</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($meetingGroups->get('', collect()) as $group)
                        <div class="rounded-2xl bg-white dark:bg-stone-800 shadow-warm border border-stone-100 dark:border-stone-700 p-4">
                            @if($group->time)
                                <p class="text-sm font-bold text-brand-700 dark:text-brand-300">{{ $group->time->format('H:i') }} Uhr</p>
                            @endif
                            <p class="font-semibold text-stone-900 dark:text-white">{{ $group->name }}</p>
                            @if($group->description)
                                <p class="text-xs text-stone-600 dark:text-stone-400 mt-1">{{ $group->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($meetingGroups->isEmpty())
            <p class="text-center text-stone-600 dark:text-stone-300 mt-10">
                Aktuell sind keine öffentlichen Sitzungsgruppen eingetragen.
            </p>
        @endif
    </div>
</x-layout>
