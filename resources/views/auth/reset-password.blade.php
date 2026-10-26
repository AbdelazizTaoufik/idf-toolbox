<x-layout title="Passwort zurücksetzen">
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            <section class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        Passwort zurücksetzen
                    </h2>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="E-Mail-Adresse" />
                        <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Neues Passwort" />
                        <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" value="Passwort bestätigen" />

                        <x-text-input id="password_confirmation" class="block mt-2 w-full"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-semibold shadow-warm transition">
                            Passwort zurücksetzen
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layout>
