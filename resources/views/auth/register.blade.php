<x-layout title="Registrieren">
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            <section class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        Registrieren
                    </h2>
                    <p class="mt-2 text-sm text-stone-600 dark:text-stone-300">
                        Erstellen Sie einen neuen Account
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-700 dark:text-stone-300">
                            Name
                        </label>
                        <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-700 dark:text-stone-300">
                            E-Mail-Adresse
                        </label>
                        <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-stone-700 dark:text-stone-300">
                            Passwort
                        </label>
                        <x-text-input id="password" class="block mt-2 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">
                            Mindestens 8 Zeichen, ein Großbuchstabe und eine Zahl erforderlich
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-stone-700 dark:text-stone-300">
                            Passwort bestätigen
                        </label>
                        <x-text-input id="password_confirmation" class="block mt-2 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-semibold shadow-warm transition">
                            Registrieren
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-stone-600 dark:text-stone-300">
                            Bereits registriert?
                            <a href="{{ route('login') }}" class="text-brand-600 dark:text-brand-300 hover:underline font-medium">
                                Hier anmelden
                            </a>
                        </p>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layout>
