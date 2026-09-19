<x-layout title="Bücherverleih">
    <div class="max-w-screen-lg mx-auto mt-8 px-4 pb-12">
        <div class="mb-6 flex items-center justify-between flex-wrap gap-3">
            <a href="{{ route('admin.view') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-stone-700 bg-white rounded-full border border-stone-200 shadow-warm hover:bg-stone-100 hover:text-brand-700 transition dark:bg-stone-800 dark:text-stone-300 dark:border-stone-600 dark:hover:bg-stone-700 dark:hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Zurück zur Admin-Seite
            </a>

            <a href="{{ route('admin.book-loans.history') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-brand-600 rounded-full hover:bg-brand-700 transition shadow-warm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historie
            </a>
        </div>

        <h1 class="text-2xl font-extrabold tracking-tight text-stone-900 dark:text-white mb-6">Bücherverleih</h1>

        <form method="GET" action="{{ route('admin.book-loans.index') }}" class="bg-white dark:bg-stone-800 rounded-2xl shadow-warm border border-stone-100 dark:border-stone-700 p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">Nutzer suchen</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name..." class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div class="flex gap-2">
                    @if(request('search'))
                        <a href="{{ route('admin.book-loans.index') }}" class="px-4 py-2 bg-stone-200 dark:bg-stone-600 text-stone-700 dark:text-white rounded-full hover:bg-stone-300 dark:hover:bg-stone-500 transition duration-300 font-medium">Zurücksetzen</a>
                    @endif
                    <button type="submit" class="px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-full transition duration-300 font-medium">Filtern</button>
                </div>
            </div>
        </form>

        <div class="space-y-3">
            @forelse($userGroups as $group)
                <details class="group bg-white dark:bg-stone-800 rounded-2xl shadow-warm border border-stone-100 dark:border-stone-700 overflow-hidden">
                    <summary class="cursor-pointer list-none px-6 py-4 flex items-center justify-between">
                        <span class="font-medium text-stone-900 dark:text-white">{{ $group['user']->name }}</span>
                        <span class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-brand-100 dark:bg-brand-900/50 text-brand-800 dark:text-brand-200 rounded-full text-xs font-semibold">
                                {{ $group['loans']->count() }} {{ $group['loans']->count() === 1 ? 'Buch' : 'Bücher' }}
                            </span>
                            <svg class="w-5 h-5 text-stone-400 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <div class="border-t border-stone-100 dark:border-stone-700 divide-y divide-stone-100 dark:divide-stone-700">
                        @foreach($group['loans'] as $loan)
                            <div class="px-6 py-4 flex items-center gap-4">
                                <x-modals.photo
                                    :id="'loan-photo-'.$loan->id"
                                    title="Leihfoto – {{ $loan->title }}"
                                    :src="route('admin.book-loans.photo', [$loan, 'loan'])"
                                >
                                    <img src="{{ route('admin.book-loans.photo', [$loan, 'loan']) }}"
                                         alt="Leihfoto {{ $loan->title }}"
                                         class="w-16 h-16 object-cover rounded-xl border border-stone-100 dark:border-stone-700 flex-shrink-0 hover:opacity-80 transition">
                                </x-modals.photo>
                                <div>
                                    <p class="font-medium text-stone-900 dark:text-white">{{ $loan->title }}</p>
                                    <p class="text-sm text-stone-500 dark:text-stone-400">
                                        Ausgeliehen am {{ $loan->loaned_at->format('d.m.Y H:i') }} Uhr
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @empty
                <p class="text-stone-500 dark:text-stone-400 text-center py-8">
                    @if(request('search'))
                        Keine Nutzer mit offenen Ausleihen gefunden.
                    @else
                        Aktuell hat niemand ein Buch ausgeliehen.
                    @endif
                </p>
            @endforelse
        </div>
    </div>
</x-layout>
