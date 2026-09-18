<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bücher-Ausleihe</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>

    <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen">
        <x-navbar/>

        <div class="max-w-screen-xl mx-auto mt-8 px-4 pb-16">
            <div class="mb-6">
                <a href="{{ route('welcome') }}" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium flex items-center gap-2">
                    ← Zurück zur Startseite
                </a>
            </div>

            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white mb-6">
                Bücher-Ausleihe
            </h1>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-100 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Formular: Buch ausleihen -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            Buch ausleihen
                        </h2>

                        <form action="{{ route('book-loans.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Titel <span class="text-red-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    value="{{ old('title') }}"
                                    class="w-full px-4 py-2 border border-red-300 dark:border-red-800 rounded-lg bg-gray-50 dark:bg-neutral-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Titel des Buches"
                                    required
                                >
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Notiz <span class="text-gray-400">(optional)</span>
                                </label>
                                <textarea
                                    name="note"
                                    id="note"
                                    rows="2"
                                    class="w-full px-4 py-2 border border-red-300 dark:border-red-800 rounded-lg bg-gray-50 dark:bg-neutral-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="z.B. Zustand, Autor, ..."
                                >{{ old('note') }}</textarea>
                                @error('note')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Foto des Buches <span class="text-red-600">*</span>
                                </label>
                                <input
                                    type="file"
                                    name="photo"
                                    id="photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-600 file:text-white file:font-semibold hover:file:bg-red-700"
                                    required
                                >
                                <p class="mt-1 text-xs text-gray-400">Große Fotos werden automatisch komprimiert.</p>
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200"
                            >
                                Ausleihe bestätigen
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Liste der aktuell ausgeliehenen Bücher -->
                <div class="lg:col-span-2">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        Meine ausgeliehenen Bücher
                    </h2>

                    <div class="space-y-4">
                        @forelse($bookLoans as $loan)
                            <div x-data="{ returning: false }" class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-4 flex gap-4">
                                <img
                                    src="{{ route('book-loans.photo', ['bookLoan' => $loan->id, 'type' => 'loan']) }}"
                                    alt="Foto von {{ $loan->title }}"
                                    class="w-20 h-20 object-cover rounded-lg flex-shrink-0"
                                >

                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $loan->title }}</p>
                                    @if($loan->note)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $loan->note }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        Ausgeliehen am {{ $loan->loaned_at->format('d.m.Y H:i') }} Uhr
                                    </p>

                                    <button
                                        x-show="!returning"
                                        @click="returning = true"
                                        type="button"
                                        class="mt-3 px-3 py-1.5 text-sm bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200"
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
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Foto: Buch ist wieder im Regal <span class="text-red-600">*</span>
                                        </label>
                                        <input
                                            type="file"
                                            name="return_photo"
                                            accept="image/jpeg,image/png,image/webp"
                                            class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-600 file:text-white file:font-semibold hover:file:bg-red-700"
                                            required
                                        >
                                        <div class="flex gap-2">
                                            <button
                                                type="submit"
                                                class="px-3 py-1.5 text-sm bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200"
                                            >
                                                Rückgabe bestätigen
                                            </button>
                                            <button
                                                type="button"
                                                @click="returning = false"
                                                class="px-3 py-1.5 text-sm bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-lg transition duration-200"
                                            >
                                                Abbrechen
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-8 text-center text-gray-500 dark:text-gray-400">
                                Du hast aktuell keine Bücher ausgeliehen.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <x-footer/>
    </body>
</html>
