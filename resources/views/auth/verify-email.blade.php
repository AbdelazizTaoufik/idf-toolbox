<x-layout title="E-Mail-Bestätigung">
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            <section class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700 p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        E-Mail-Bestätigung
                    </h2>
                    <p class="mt-2 text-sm text-stone-600 dark:text-stone-300">
                        Bestätigen Sie Ihre E-Mail-Adresse
                    </p>
                </div>

                <div class="bg-brand-50 dark:bg-brand-900/30 border border-brand-100 dark:border-brand-800 rounded-2xl p-4">
                    <p class="text-sm text-stone-700 dark:text-stone-300">
                        Vielen Dank für Ihre Registrierung! Bitte bestätigen Sie Ihre E-Mail-Adresse, indem Sie auf den Link klicken, den wir Ihnen gerade gesendet haben. Wenn Sie die E-Mail nicht erhalten haben, können wir Ihnen gerne eine neue senden.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-2xl p-4">
                        <p class="text-sm font-medium text-green-800 dark:text-green-300">
                            Ein neuer Verifikationslink wurde an Ihre E-Mail-Adresse gesendet!
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-semibold shadow-warm transition">
                        Verifikations-E-Mail erneut senden
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-xs text-stone-500 dark:text-stone-400">
                        Sie können sich jederzeit abmelden, indem Sie den Logout-Button in der Navigation verwenden.
                    </p>
                </div>
            </section>
        </div>
    </div>
</x-layout>
