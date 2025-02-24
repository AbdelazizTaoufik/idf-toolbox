<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <x-navbar/>
    
    <body class="bg-gray-100 dark:bg-idfDarkRed">
        <div class="relative overflow-x-auto shadow-md rounded-xl max-w-screen-lg mx-auto my-8">
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
                        <tr class="bg-white dark:bg-red-950 border-b border-red-200 dark:border-red-900">
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
        
    </body>
    <x-footer/>
</html>
