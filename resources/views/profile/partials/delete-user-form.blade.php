<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-stone-900 dark:text-white">
            Konto löschen
        </h2>

        <p class="mt-1 text-sm text-stone-600 dark:text-stone-400">
            Sobald Ihr Konto gelöscht ist, werden alle zugehörigen Daten unwiderruflich entfernt. Laden Sie vor der Löschung alle Daten herunter, die Sie behalten möchten.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Konto löschen</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-stone-900 dark:text-white">
                Möchten Sie Ihr Konto wirklich löschen?
            </h2>

            <p class="mt-1 text-sm text-stone-600 dark:text-stone-400">
                Sobald Ihr Konto gelöscht ist, werden alle zugehörigen Daten unwiderruflich entfernt. Bitte geben Sie Ihr Passwort ein, um die Löschung zu bestätigen.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Passwort" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Passwort"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Abbrechen
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    Konto löschen
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
