<x-layout title="Bücher-Ausleihe">
    <div class="max-w-screen-xl mx-auto mt-8 px-4 pb-16">
        <div class="mb-6">
            <a href="{{ route('welcome') }}" class="text-brand-600 hover:text-brand-700 dark:text-brand-300 dark:hover:text-brand-200 font-medium flex items-center gap-2">
                ← Zurück zur Startseite
            </a>
        </div>

        <h1 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white mb-6">
            Bücher-Ausleihe
        </h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/40 text-green-700 dark:text-green-200 rounded-2xl flex items-center gap-2 border border-green-100 dark:border-green-800">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formular: Buch ausleihen -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-stone-900 dark:text-white mb-4">
                        Buch ausleihen
                    </h2>

                    <form action="{{ route('book-loans.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Titel <span class="text-brand-600 dark:text-brand-400">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title') }}"
                                class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                placeholder="Titel des Buches"
                                required
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-brand-600 dark:text-brand-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="note" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Notiz <span class="text-stone-400 dark:text-stone-500">(optional)</span>
                            </label>
                            <textarea
                                name="note"
                                id="note"
                                rows="2"
                                class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                placeholder="z.B. Zustand, Autor, ..."
                            >{{ old('note') }}</textarea>
                            @error('note')
                                <p class="mt-1 text-sm text-brand-600 dark:text-brand-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Foto des Buches <span class="text-brand-600 dark:text-brand-400">*</span>
                            </label>
                            <input
                                type="file"
                                name="photo"
                                id="photo"
                                accept="image/jpeg,image/png,image/webp"
                                class="w-full text-sm text-stone-700 dark:text-stone-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-brand-600 file:text-white file:font-semibold hover:file:bg-brand-700"
                                required
                            >
                            <p class="mt-1 text-xs text-stone-400 dark:text-stone-500">Große Fotos werden automatisch komprimiert.</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-brand-600 dark:text-brand-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full transition duration-200 shadow-warm hover:shadow-warm-lg"
                        >
                            Ausleihe bestätigen
                        </button>
                    </form>
                </div>
            </div>

            <!-- Liste der aktuell ausgeliehenen Bücher -->
            <div class="lg:col-span-2">
                <h2 class="text-xl font-bold text-stone-900 dark:text-white mb-4">
                    Meine ausgeliehenen Bücher
                </h2>

                <div class="space-y-4">
                    @forelse($bookLoans as $loan)
                        <div x-data="{ returning: false }" class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-4 flex gap-4">
                            <img
                                src="{{ route('book-loans.photo', ['bookLoan' => $loan->id, 'type' => 'loan']) }}"
                                alt="Foto von {{ $loan->title }}"
                                class="w-20 h-20 object-cover rounded-2xl flex-shrink-0"
                            >

                            <div class="flex-1">
                                <p class="font-semibold text-stone-900 dark:text-white">{{ $loan->title }}</p>
                                @if($loan->note)
                                    <p class="text-sm text-stone-600 dark:text-stone-400">{{ $loan->note }}</p>
                                @endif
                                <p class="text-xs text-stone-400 dark:text-stone-500 mt-1">
                                    Ausgeliehen am {{ $loan->loaned_at->format('d.m.Y H:i') }} Uhr
                                </p>

                                <button
                                    x-show="!returning"
                                    @click="returning = true"
                                    type="button"
                                    class="mt-3 px-3 py-1.5 text-sm bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full transition duration-200"
                                >
                                    Zurückgeben
                                </button>

                                <form
                                    x-show="returning"
                                    action="{{ route('book-loans.return', $loan->id) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="mt-3 space-y-2"
                                >
                                    @csrf
                                    <label class="block text-sm font-medium text-stone-700 dark:text-stone-300">
                                        Foto: Buch ist wieder im Regal <span class="text-brand-600 dark:text-brand-400">*</span>
                                    </label>
                                    <input
                                        type="file"
                                        name="return_photo"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="w-full text-sm text-stone-700 dark:text-stone-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-brand-600 file:text-white file:font-semibold hover:file:bg-brand-700"
                                        required
                                    >
                                    <div class="flex gap-2">
                                        <button
                                            type="submit"
                                            class="px-3 py-1.5 text-sm bg-green-600 hover:bg-green-700 text-white font-semibold rounded-full transition duration-200"
                                        >
                                            Rückgabe bestätigen
                                        </button>
                                        <button
                                            type="button"
                                            @click="returning = false"
                                            class="px-3 py-1.5 text-sm bg-stone-200 dark:bg-stone-600 hover:bg-stone-300 dark:hover:bg-stone-500 text-stone-900 dark:text-white font-semibold rounded-full transition duration-200"
                                        >
                                            Abbrechen
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 text-center text-stone-500 dark:text-stone-400">
                            Du hast aktuell keine Bücher ausgeliehen.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layout>
