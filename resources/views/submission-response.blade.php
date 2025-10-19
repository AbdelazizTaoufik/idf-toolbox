<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Danke!</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-t from-white via-red-200 to-white dark:bg-gradient-to-t dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
        
        <x-navbar/>

        <main class="flex-grow flex items-center justify-center p-4">
            <div class="bg-white dark:bg-red-950 relative overflow-hidden shadow-lg rounded-2xl max-w-md w-full text-center">
                <div class="relative w-full h-56">
                    <img class="absolute inset-0 w-full h-full object-cover rounded-t-2xl" 
                         src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExNTVqYXowMzF6d2Z2bjMyOWZ2bWt5YnZvNDhpZTFzcncwN3dyb2thdSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/1AHCZObMNvSHFMweqC/giphy.gif" 
                         alt="Danke GIF" />
                </div>
                <div class="p-6">
                    <h5 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">Vielen Dank für deinen Beitrag!</h5>
                    <p class="text-gray-700 dark:text-gray-300 text-lg">Dein Beitrag wurde anonym übermittelt. Wir schätzen dein Vertrauen und werden uns In schāʾa llāh um dein Anliegen kümmern.</p>
                </div>
                <div class="px-6 pb-6">
                    <a href="/" 
                       class="inline-block w-full bg-red-900 hover:bg-red-800 text-white font-semibold py-3 rounded-2xl transition-all duration-300">
                        Zurück zur Startseite
                    </a>
                </div>
            </div>
        </main>

        <x-footer/>
    </body>
</html>