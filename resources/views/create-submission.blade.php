<x-layout title="Kummerkasten">
    <div class="flex flex-col items-center justify-center p-4 py-16">
        <div class="max-w-md w-full mb-6">
            <a href="{{ route('welcome') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-stone-700 bg-white rounded-full border border-stone-200 shadow-warm hover:bg-stone-100 hover:text-brand-700 transition dark:bg-stone-800 dark:text-stone-300 dark:border-stone-600 dark:hover:bg-stone-700 dark:hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Zurück zur Startseite
            </a>
        </div>
        <div class="bg-white dark:bg-stone-800 rounded-3xl shadow-warm-lg border border-stone-100 dark:border-stone-700 max-w-md w-full">
            <form id="submissionForm" action="{{ route('store.submission') }}" method="POST" class="p-6 md:p-8">
                @csrf
                <h1 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white mb-6">
                    Kummerkasten
                </h1>
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="meeting_group_id" class="text-left block mb-2 text-sm font-medium text-stone-700 dark:text-stone-200">Sitzungsgruppe <span class="text-stone-400 dark:text-stone-500">(optional)</span></label>
                        <select name="meeting_group_id" id="meeting_group_id" class="bg-stone-50 dark:bg-stone-700 border border-stone-200 dark:border-stone-600 text-stone-900 dark:text-white text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 focus:ring-2 block w-full p-2.5 dark:placeholder-stone-400 transition">
                            <option value="">-- Keine Sitzungsgruppe --</option>
                            @foreach($meetingGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="title" class="text-left block mb-2 text-sm font-medium text-stone-700 dark:text-stone-200">Betreff</label>
                        <input type="text" name="title" id="title" class="bg-stone-50 dark:bg-stone-700 border border-stone-200 dark:border-stone-600 text-stone-900 dark:text-white text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 focus:ring-2 block w-full p-2.5 transition dark:placeholder-stone-400" required>
                    </div>
                    <div class="col-span-2">
                        <label for="text" class="text-left block mb-2 text-sm font-medium text-stone-700 dark:text-stone-200">Inhalt</label>
                        <textarea name="text" id="text" rows="4" class="block p-2.5 w-full text-sm text-stone-900 dark:text-white bg-stone-50 dark:bg-stone-700 rounded-xl border border-stone-200 dark:border-stone-600 focus:ring-brand-500 focus:border-brand-500 focus:ring-2 transition dark:placeholder-stone-400" required></textarea>
                    </div>
                </div>
                <button type="submit" class="w-full text-white inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 focus:ring-4 focus:outline-none focus:ring-brand-300 dark:focus:ring-brand-800 font-semibold rounded-full text-sm px-5 py-2.5 text-center transition shadow-warm hover:shadow-warm-lg">
                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd"/>
                    </svg>
                    Absenden
                </button>
            </form>
        </div>
    </div>
</x-layout>
