<x-layout title="Anmelden">
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            <section class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        Anmelden
                    </h2>
                    <p class="mt-2 text-sm text-stone-600 dark:text-stone-300">
                        Melden Sie sich in Ihrem Konto an
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-700 dark:text-stone-300">
                            E-Mail-Adresse
                        </label>
                        <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
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
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 rounded text-brand-600 dark:text-brand-500 dark:bg-stone-800 border-stone-300 dark:border-stone-600 focus:ring-brand-400 dark:focus:ring-brand-400 dark:focus:ring-offset-stone-800" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-stone-700 dark:text-stone-300">
                            Anmeldedaten merken
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-semibold shadow-warm transition">
                            Anmelden
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layout>
