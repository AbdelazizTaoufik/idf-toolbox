<x-layout title="Passwort vergessen">
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            <section class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        Passwort vergessen
                    </h2>
                </div>

                <div class="text-sm text-stone-600 dark:text-stone-300">
                    Passwort vergessen? Kein Problem. Geben Sie Ihre E-Mail-Adresse an und wir senden Ihnen einen Link, mit dem Sie ein neues Passwort wählen können.
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="E-Mail-Adresse" />
                        <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-semibold shadow-warm transition">
                            Link zum Zurücksetzen senden
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layout>
