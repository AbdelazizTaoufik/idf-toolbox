<x-layout title="Bücherverleih-Historie">
    <div class="max-w-screen-lg mx-auto mt-8 px-4 pb-12">
        <div class="mb-6">
            <a href="{{ route('admin.book-loans.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-stone-700 bg-white rounded-full border border-stone-200 shadow-warm hover:bg-stone-100 hover:text-brand-700 transition dark:bg-stone-800 dark:text-stone-300 dark:border-stone-600 dark:hover:bg-stone-700 dark:hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Zurück zur Übersicht
            </a>
        </div>

        <h1 class="text-2xl font-extrabold tracking-tight text-stone-900 dark:text-white mb-6">Bücherverleih-Historie</h1>

        <form method="GET" action="{{ route('admin.book-loans.history') }}" class="bg-white dark:bg-stone-800 rounded-2xl shadow-warm border border-stone-100 dark:border-stone-700 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="user" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">Nutzer</label>
                    <input type="text" name="user" id="user" list="user-suggestions" value="{{ request('user') }}" placeholder="Name..." autocomplete="off" class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <datalist id="user-suggestions">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}">
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label for="loaned_from" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">Leihdatum von</label>
                    <input type="date" name="loaned_from" id="loaned_from" value="{{ request('loaned_from') }}" class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div>
                    <label for="loaned_to" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">Leihdatum bis</label>
                    <input type="date" name="loaned_to" id="loaned_to" value="{{ request('loaned_to') }}" class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div>
                    <label for="returned_from" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">Rückgabe von</label>
                    <input type="date" name="returned_from" id="returned_from" value="{{ request('returned_from') }}" class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div>
                    <label for="returned_to" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">Rückgabe bis</label>
                    <input type="date" name="returned_to" id="returned_to" value="{{ request('returned_to') }}" class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('admin.book-loans.history') }}" class="px-4 py-2 bg-stone-200 dark:bg-stone-600 text-stone-700 dark:text-white rounded-full hover:bg-stone-300 dark:hover:bg-stone-500 transition duration-300 font-medium">Zurücksetzen</a>
                <button type="submit" class="px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-full transition duration-300 font-medium">Filtern</button>
            </div>
        </form>

        <div class="bg-white dark:bg-stone-800 rounded-2xl shadow-warm border border-stone-100 dark:border-stone-700 overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-brand-50 dark:bg-brand-900/30 text-brand-800 dark:text-brand-200 border-b-2 border-brand-200 dark:border-brand-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Nutzer</th>
                            <th class="px-4 py-3 text-left font-semibold">Titel</th>
                            <th class="px-4 py-3 text-left font-semibold">Leihdatum</th>
                            <th class="px-4 py-3 text-left font-semibold">Rückgabedatum</th>
                            <th class="px-4 py-3 text-center font-semibold">Fotos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 dark:divide-stone-700">
                        @forelse($bookLoans as $loan)
                            <tr class="hover:bg-stone-50 dark:hover:bg-stone-700/50 transition">
                                <td class="px-4 py-4 font-medium text-stone-900 dark:text-white">{{ $loan->user->name }}</td>
                                <td class="px-4 py-4 text-stone-700 dark:text-stone-300">{{ $loan->title }}</td>
                                <td class="px-4 py-4 text-stone-600 dark:text-stone-400">{{ $loan->loaned_at->format('d.m.Y H:i') }} Uhr</td>
                                <td class="px-4 py-4 text-stone-600 dark:text-stone-400">{{ $loan->returned_at->format('d.m.Y H:i') }} Uhr</td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-modals.photo
                                            :id="'loan-photo-'.$loan->id"
                                            title="Leihfoto – {{ $loan->title }}"
                                            :src="route('admin.book-loans.photo', [$loan, 'loan'])"
                                            label="Leihfoto"
                                        />
                                        <x-modals.photo
                                            :id="'return-photo-'.$loan->id"
                                            title="Rückgabefoto – {{ $loan->title }}"
                                            :src="route('admin.book-loans.photo', [$loan, 'return'])"
                                            label="Rückgabefoto"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-stone-500 dark:text-stone-400">Keine abgeschlossenen Ausleihen gefunden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($bookLoans->hasPages())
            <div class="mt-6 flex justify-center mb-8">
                {{ $bookLoans->links('components.custom-pagination') }}
            </div>
        @endif
    </div>
</x-layout>
