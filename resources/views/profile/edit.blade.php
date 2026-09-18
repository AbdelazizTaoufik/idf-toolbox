<x-layout title="Profil">
    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="font-extrabold tracking-tight text-xl text-stone-900 dark:text-white">
                {{ __('Profile') }}
            </h2>

            <div class="p-6 sm:p-8 bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-stone-800 rounded-3xl shadow-warm border border-stone-100 dark:border-stone-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layout>
