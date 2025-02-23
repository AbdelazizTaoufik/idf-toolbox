<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <x-navbar/>
    
    <body class="bg-gray-100 dark:bg-gray-950">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-screen-xl mx-auto mt-8">
            <table class="w-full text-sm text-left rtl:text-right text-red-100">
                <thead class="text-xs text-white uppercase bg-red-900 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Color
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                @foreach($submissions as $submission)
                <tbody>
                    <tr class="bg-white dark:bg-red-950 border-b border-red-200 dark:border-red-900">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-800 dark:text-white whitespace-nowrap ">
                            {{$submission->title}}
                        </th>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">
                            Silver
                        </td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">
                            Laptop
                        </td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">
                            $2999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-gray-800 dark:text-white hover:underline">Edit</a>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </body>
</html>
