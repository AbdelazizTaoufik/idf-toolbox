<x-layout title="Sitzungsgruppen">
    <div class="max-w-screen-xl mx-auto mt-8 px-4 pb-12">
        <!-- Zurück zum Admin -->
        <div class="mb-6">
            <a href="{{ route('admin.view') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-stone-700 bg-white rounded-full border border-stone-200 shadow-warm hover:bg-stone-100 hover:text-brand-700 transition dark:bg-stone-800 dark:text-stone-300 dark:border-stone-600 dark:hover:bg-stone-700 dark:hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Zurück zur Admin-Seite
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formular zum Hinzufügen -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-stone-800 rounded-2xl shadow-warm border border-stone-100 dark:border-stone-700 p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-stone-900 dark:text-white mb-4">
                        Neue Sitzungsgruppe
                    </h2>

                    <form action="{{ route('meeting-groups.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Name <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                placeholder="z.B. Vorstand"
                                required
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Beschreibung <span class="text-stone-400">(optional)</span>
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                rows="2"
                                class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                placeholder="Beschreibung der Gruppe..."
                            ></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="weekday" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Wochentag <span class="text-stone-400">(optional)</span>
                            </label>
                            <select
                                name="weekday"
                                id="weekday"
                                class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                            >
                                <option value="">-- Nicht festgelegt --</option>
                                @foreach($weekdays as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('weekday')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                                Uhrzeit <span class="text-stone-400">(optional)</span>
                            </label>
                            <input
                                type="time"
                                name="time"
                                id="time"
                                class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                            >
                            @error('time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="is_public"
                                id="is_public"
                                value="1"
                                checked
                                class="w-4 h-4 text-brand-600 rounded focus:ring-2 focus:ring-brand-500"
                            >
                            <label for="is_public" class="text-sm font-medium text-stone-700 dark:text-stone-300">
                                Öffentlich
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full transition duration-200"
                        >
                            Hinzufügen
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabelle mit existierenden Gruppen -->
            <div class="lg:col-span-2">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-100 rounded-2xl flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-stone-800 rounded-2xl shadow-warm border border-stone-100 dark:border-stone-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-brand-50 dark:bg-brand-900/30 text-brand-800 dark:text-brand-200 border-b-2 border-brand-200 dark:border-brand-800">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Name</th>
                                    <th class="px-4 py-3 text-left font-semibold">Wochentag</th>
                                    <th class="px-4 py-3 text-left font-semibold">Uhrzeit</th>
                                    <th class="px-4 py-3 text-center font-semibold">Öffentlich</th>
                                    <th class="px-4 py-3 text-center font-semibold">Aktionen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 dark:divide-stone-700">
                                @forelse($meetingGroups as $group)
                                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-700/50 transition">
                                        <td class="px-4 py-4 font-medium text-stone-900 dark:text-white">
                                            {{ $group->name }}
                                        </td>
                                        <td class="px-4 py-4 text-stone-600 dark:text-stone-400 text-sm">
                                            @if($group->weekday)
                                                {{ $weekdays[$group->weekday] }}
                                            @else
                                                <span class="text-stone-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-stone-600 dark:text-stone-400 text-sm">
                                            @if($group->time)
                                                {{ $group->time->format('H:i') }} Uhr
                                            @else
                                                <span class="text-stone-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @if($group->is_public)
                                                <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 text-xs font-semibold rounded-full">Ja</span>
                                            @else
                                                <span class="inline-block px-2 py-1 bg-stone-100 dark:bg-stone-700 text-stone-700 dark:text-stone-300 text-xs font-semibold rounded-full">Nein</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button
                                                    onclick="editGroup('{{ $group->id }}', '{{ $group->name }}', '{{ addslashes($group->description) }}', '{{ $group->weekday }}', '{{ $group->time?->format('H:i') }}', {{ $group->is_public ? 'true' : 'false' }})"
                                                    class="inline-flex items-center justify-center p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-full transition duration-200"
                                                    title="Bearbeiten"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>

                                                <form
                                                    action="{{ route('meeting-groups.destroy', $group->id) }}"
                                                    method="POST"
                                                    style="display: inline;"
                                                    onsubmit="return confirm('Möchten Sie diese Sitzungsgruppe wirklich löschen?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900 rounded-full transition duration-200"
                                                        title="Löschen"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-stone-500 dark:text-stone-400">
                                            Noch keine Sitzungsgruppen vorhanden.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($meetingGroups->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $meetingGroups->links('components.custom-pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white dark:bg-stone-800 rounded-2xl shadow-warm-lg border border-stone-100 dark:border-stone-700 max-w-md w-full max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-stone-200 dark:border-stone-700 sticky top-0 bg-white dark:bg-stone-800 rounded-t-2xl">
                <h3 class="text-lg font-bold text-stone-900 dark:text-white">
                    Sitzungsgruppe bearbeiten
                </h3>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="editName" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                        Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="editName"
                        class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        required
                    >
                </div>

                <div>
                    <label for="editDescription" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                        Beschreibung
                    </label>
                    <textarea
                        name="description"
                        id="editDescription"
                        rows="2"
                        class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                    ></textarea>
                </div>

                <div>
                    <label for="editWeekday" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                        Wochentag
                    </label>
                    <select
                        name="weekday"
                        id="editWeekday"
                        class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                    >
                        <option value="">-- Nicht festgelegt --</option>
                        @foreach($weekdays as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="editTime" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1">
                        Uhrzeit
                    </label>
                    <input
                        type="time"
                        name="time"
                        id="editTime"
                        class="w-full px-4 py-2 border border-stone-200 dark:border-stone-600 rounded-xl bg-stone-50 dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="is_public"
                        id="editIsPublic"
                        value="1"
                        class="w-4 h-4 text-brand-600 rounded focus:ring-2 focus:ring-brand-500"
                    >
                    <label for="editIsPublic" class="text-sm font-medium text-stone-700 dark:text-stone-300">
                        Öffentlich
                    </label>
                </div>

                <div class="flex gap-2 pt-4">
                    <button
                        type="submit"
                        class="flex-1 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full transition duration-200"
                    >
                        Speichern
                    </button>
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="flex-1 px-4 py-2 bg-stone-200 dark:bg-stone-600 hover:bg-stone-300 dark:hover:bg-stone-500 text-stone-900 dark:text-white font-semibold rounded-full transition duration-200"
                    >
                        Abbrechen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editGroup(id, name, description, weekday, time, isPublic) {
            document.getElementById('editForm').action = `/admin/meeting-groups/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editWeekday').value = weekday;
            document.getElementById('editTime').value = time || '';
            document.getElementById('editIsPublic').checked = isPublic;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</x-layout>
