<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    
    <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900">
        <x-navbar/>
        <div class="max-w-screen-lg mx-auto mt-8 fade-in px-4">
            <div class="mb-6">
                <a href="{{ route('admin.view') }}" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium flex items-center gap-2">
                    ← Zurück zur Admin-Seite
                </a>
            </div>

            <form method="GET" action="{{ route('admin.submission.view') }}" class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    <!-- Search -->
                    <div class="flex items-center space-x-2 md:col-span-4">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" 
                               placeholder="Suche nach Beitrag..."
                               value="{{ request('search') }}"
                               class="px-4 py-2 w-full bg-gray-50 dark:bg-neutral-700 border border-red-300 dark:border-red-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:text-white">
                    </div>

                    <!-- Filter by Meeting Group -->
                    <div class="flex items-center space-x-2 md:col-span-4">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <select name="meeting_group_id" class="px-4 py-2 w-full bg-gray-50 dark:bg-neutral-700 border border-red-300 dark:border-red-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:text-white">
                            <option value="">-- Alle Sitzungsgruppen --</option>
                            @foreach($meetingGroups as $group)
                                <option value="{{ $group->id }}" {{ request('meeting_group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2 md:col-span-4">
                        <button type="submit" class="flex items-center justify-center gap-2 px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition duration-300 font-medium flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <span class="hidden sm:inline">Filtern</span>
                        </button>
                        
                        @if(request('search') || request('meeting_group_id'))
                            <a href="{{ route('admin.submission.view') }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition duration-300 font-medium flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="hidden sm:inline">Zurücksetzen</span>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        
        
        <div class="relative overflow-x-auto shadow-lg rounded-xl max-w-screen-lg mx-auto my-8 fade-in">
            <table class="w-full text-sm text-left rtl:text-right text-red-100">
                <thead class="text-xs text-white uppercase bg-red-900 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-32">Betreff</th>
                        <th scope="col" class="px-6 py-3 w-32">Sitzungsgruppe</th>
                        <th scope="col" class="px-6 py-3 text-center w-24">Erstellt am:</th>
                        <th scope="col" class="px-6 py-3 text-center w-24">Lesen</th>
                        <th scope="col" class="px-6 py-3 text-center w-24">Löschen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr class="bg-white hover:bg-red-200 dark:bg-red-950 dark:hover:bg-red-800 border-b border-red-200 dark:border-red-900">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 dark:text-white whitespace-nowrap">
                                {{$submission->title}}
                            </th>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                @if($submission->meetingGroup)
                                    <span class="bg-red-200 dark:bg-red-900 text-red-900 dark:text-red-100 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $submission->meetingGroup->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400 italic">Keine Gruppe</span>
                                @endif
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-800 dark:text-white whitespace-nowrap text-center">
                                {{$submission->created_at->format('d.m.Y H:i:s')}} Uhr
                            </th>
                            <td class="px-1 py-4 text-gray-800 dark:text-white text-center">
                                <x-modals.information
                                    :id="$submission->id"
                                    :title="$submission->title"
                                    :text="$submission->text"
                                />
                            </td>
                            <td class="px-1 py-4 text-center">
                                <x-modals.delete-item 
                                    :id="$submission->id"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="m-6 flex justify-center">
            {{ $submissions->links('components.custom-pagination')}}
        </div>
        
        <x-footer/>
    </body>
</html>
