<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col">
        <x-navbar/>
        <main class="flex-1 flex items-center justify-center p-4">
            <div class="bg-white/60 dark:bg-neutral-900/60 backdrop-blur-md relative overflow-hidden shadow-2xl rounded-3xl border border-white/10 max-w-md w-full">
                <form id="submissionForm" action="{{ route('store.submission') }}" method="POST" class="p-6 md:p-8">
                    @csrf
                    <h1 class="text-3xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400 mb-6">
                        Kummerkasten
                    </h1>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="meeting_group_id" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-neutral-200">Sitzungsgruppe <span class="text-gray-500 dark:text-gray-400">(optional)</span></label>
                            <select name="meeting_group_id" id="meeting_group_id" class="bg-gray-50 dark:bg-neutral-800 border border-gray-300 dark:border-neutral-700 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-red-500 focus:border-red-500 focus:ring-2 block w-full p-2.5 dark:placeholder-gray-500 transition">
                                <option value="">-- Keine Sitzungsgruppe --</option>
                                @foreach($meetingGroups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="title" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-neutral-200">Betreff</label>
                            <input type="text" name="title" id="title" class="bg-gray-50 dark:bg-neutral-800 border border-gray-300 dark:border-neutral-700 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-red-500 focus:border-red-500 focus:ring-2 block w-full p-2.5 transition dark:placeholder-gray-500" required>
                        </div>
                        <div class="col-span-2">
                            <label for="text" class="text-left block mb-2 text-sm font-medium text-gray-900 dark:text-neutral-200">Inhalt</label>
                            <textarea name="text" id="text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-neutral-800 rounded-lg border border-gray-300 dark:border-neutral-700 focus:ring-red-500 focus:border-red-500 focus:ring-2 transition dark:placeholder-gray-500" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-semibold rounded-lg text-sm px-5 py-2.5 text-center transition shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd"/>
                        </svg>     
                        Absenden
                    </button>
                </form>
            </div>
        </main>
        <x-footer/>
    </body>
</html>
