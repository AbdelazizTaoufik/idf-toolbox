<x-layout title="Passwort bestätigen">
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            <section class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        Passwort bestätigen
                    </h2>
                </div>

                <div class="text-sm text-stone-600 dark:text-stone-300">
                    Dies ist ein geschützter Bereich der Anwendung. Bitte bestätigen Sie Ihr Passwort, bevor Sie fortfahren.
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Passwort" />

                        <x-text-input id="password" class="block mt-2 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-semibold shadow-warm transition">
                            Bestätigen
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layout>
