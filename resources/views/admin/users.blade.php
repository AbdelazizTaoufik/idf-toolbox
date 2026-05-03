<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Benutzerverwaltung - Admin</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    
    <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col">
        <x-navbar/>
        
        <div class="max-w-screen-xl mx-auto mt-8 px-4 flex-1 w-full">
            <!-- Zurück zum Admin -->
            <div class="mb-6">
                <a href="{{ route('admin.view') }}" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium flex items-center gap-2">
                    ← Zurück zur Admin-Seite
                </a>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Benutzerverwaltung</h1>

            <!-- Filter & Suche -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Suche -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Suche (Name, E-Mail)</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Suchen..." class="w-full px-4 py-2 border border-red-300 dark:border-red-800 rounded-lg bg-gray-50 dark:bg-neutral-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Filter: Admin -->
                    <div>
                        <label for="is_admin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rolle</label>
                        <select name="is_admin" id="is_admin" class="w-full px-4 py-2 border border-red-300 dark:border-red-800 rounded-lg bg-gray-50 dark:bg-neutral-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500">
                            <option value="">Alle Rollen</option>
                            <option value="1" {{ request('is_admin') === '1' ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ request('is_admin') === '0' ? 'selected' : '' }}>Benutzer</option>
                        </select>
                    </div>

                    <!-- Filter: Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-red-300 dark:border-red-800 rounded-lg bg-gray-50 dark:bg-neutral-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500">
                            <option value="">Alle Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktiviert</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inaktiv</option>
                        </select>
                    </div>

                    <!-- Per Page -->
                    <div>
                        <label for="per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anzeigen</label>
                        <select name="per_page" id="per_page" class="w-full px-4 py-2 border border-red-300 dark:border-red-800 rounded-lg bg-gray-50 dark:bg-neutral-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition duration-300 font-medium">Zurücksetzen</a>
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300 font-medium">Filtern</button>
                </div>
            </form>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-100 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-100 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-red-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Name</th>
                                <th class="px-4 py-3 text-left font-semibold">E-Mail</th>
                                <th class="px-4 py-3 text-center font-semibold">Aktiviert</th>
                                <th class="px-4 py-3 text-center font-semibold">Admin</th>
                                <th class="px-4 py-3 text-left font-semibold">Erstellt am</th>
                                <th class="px-4 py-3 text-center font-semibold">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-200 dark:divide-red-900">
                            @forelse($users as $user)
                                <tr class="hover:bg-red-50 dark:hover:bg-red-950 transition">
                                    <td class="px-4 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($user->email_verified_at)
                                            <div class="flex flex-col items-center">
                                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->email_verified_at->format('d.m.Y H:i') }}</span>
                                            </div>
                                        @else
                                            <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($user->is_admin)
                                            <span class="inline-block px-2 py-1 bg-red-200 dark:bg-red-900 text-red-900 dark:text-red-100 text-xs font-semibold rounded">Ja</span>
                                        @else
                                            <span class="inline-block px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded">Nein</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                                        {{ $user->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($user->email_verified_at && $user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" onsubmit="return confirm('Möchten Sie den Admin-Status für diesen Benutzer wirklich ändern?');">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-200">
                                                    {{ $user->is_admin ? 'Admin entziehen' : 'Admin machen' }}
                                                </button>
                                            </form>
                                        @elseif($user->id === auth()->id())
                                            <span class="text-xs text-gray-400 italic">Sie (Selbst)</span>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Nicht aktiviert</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Keine Benutzer gefunden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($users->hasPages())
                <div class="mt-6 flex justify-center mb-8">
                    {{ $users->links('components.custom-pagination') }}
                </div>
            @endif
        </div>

        <x-footer/>
    </body>
</html>
