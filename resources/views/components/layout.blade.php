@props(['title' => null])
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title.' – Islamische Denkfabrik Toolbox' : 'Islamische Denkfabrik Toolbox' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-col bg-stone-50 dark:bg-brand-950 text-stone-800 dark:text-stone-200 font-sans antialiased">
        <x-navbar/>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-footer/>
    </body>
</html>
