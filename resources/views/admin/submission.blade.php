<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css','resources/js/app.js'])
        <style>
            /* Smooth transition effects */
            
        </style>
    </head>
    
    <body class="bg-gradient-to-t from-white via-red-200 to-white dark:bg-gradient-to-t dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900">
        <x-navbar/>
        <div class="max-w-screen-lg mx-auto mt-8 fade-in">
            <form method="GET" action="{{ route('admin.submission.view') }}" class="flex items-center space-x-2">
                <input type="text" name="search" 
                       placeholder="🔍 Suche nach Beitrag..."
                       value="{{ request('search') }}"
                       class="px-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600">
                
                <button type="submit" 
                        class="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition duration-300">
                    Suchen
                </button>
                
                @if(request('search'))
                    <a href="{{ route('admin.submission.view') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-300">
                        Zurücksetzen
                    </a>
                @endif
            </form>
        </div>
        
        <div class="relative overflow-x-auto shadow-md rounded-xl max-w-screen-lg mx-auto my-8 fade-in">
            <table class="w-full text-sm text-left rtl:text-right text-red-100">
                <thead class="text-xs text-white uppercase bg-red-900 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-64">Betreff</th>
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
