<x-layout title="Admin">
    <div class="flex flex-col items-center justify-center py-16 px-4">
        @php $user = auth()->user(); @endphp
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-200 text-sm font-semibold">
                Admin-Bereich
            </span>
            <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                Willkommen zurück
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-4xl">
            @if($user->hasModuleAccess(\App\Models\AdminModule::USERS))
                <x-admin-card
                    url="{{ route('admin.users.index') }}"
                    svg="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    title="Benutzerverwaltung"
                    description="Verwalte alle Benutzer und deren Rechte."
                />
            @endif

            @if($user->hasModuleAccess(\App\Models\AdminModule::SUBMISSIONS))
                <x-admin-card
                    url="{{ route('admin.submission.view') }}"
                    svg="M11 16v-5.5A3.5 3.5 0 0 0 7.5 7m3.5 9H4v-5.5A3.5 3.5 0 0 1 7.5 7m3.5 9v4M7.5 7H14m0 0V4h2.5M14 7v3m-3.5 6H20v-6a3 3 0 0 0-3-3m-2 9v4m-8-6.5h1"
                    title="Kummerkasteneinträge"
                    description="Sieh dir die Einträge aus dem Kummerkasten an."
                />
            @endif

            @if($user->hasModuleAccess(\App\Models\AdminModule::MEETING_GROUPS))
                <x-admin-card
                    url="{{ route('meeting-groups.index') }}"
                    svg="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM9 16a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6z"
                    title="Sitzungsgruppen"
                    description="Verwalte die Sitzungsgruppen."
                />
            @endif

            @if($user->hasModuleAccess(\App\Models\AdminModule::BOOK_LOANS))
                <x-admin-card
                    url="{{ route('admin.book-loans.index') }}"
                    svg="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    title="Bücherverleih"
                    description="Übersicht über aktuelle und vergangene Ausleihen."
                />
            @endif

            @unless($user->hasModuleAccess(\App\Models\AdminModule::USERS) || $user->hasModuleAccess(\App\Models\AdminModule::SUBMISSIONS) || $user->hasModuleAccess(\App\Models\AdminModule::MEETING_GROUPS) || $user->hasModuleAccess(\App\Models\AdminModule::BOOK_LOANS))
                <p class="text-stone-600 dark:text-stone-300 md:col-span-3 text-center">
                    Ihnen wurden noch keine Berechtigungen zugewiesen. Bitte wenden Sie sich an einen Administrator mit Zugriff auf die Benutzerverwaltung.
                </p>
            @endunless
        </div>
    </div>
</x-layout>
