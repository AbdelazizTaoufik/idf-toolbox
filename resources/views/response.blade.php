<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <x-navbar/>
    <body class="bg-gray-100 dark:bg-idfDarkRed">
        <div class="bg-white dark:bg-red-950 relative overflow-x-auto shadow-md rounded-xl max-w-screen-sm mx-auto mt-8">
            <div class="flex justify-center">
                <img class="rounded-t-lg mx-auto" src="https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExbHYzY3gxaDEzejA3YWoxNWtmemRrMjloMjJyNXZmbGVmeXJzcTZ2bCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/26FLdmIp6wJr91JAI/giphy.gif" alt="" />
            </div>
            <div class="p-5 text-center">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Vielen Dank für deinen Beitrag!</h5>
            </div>
        </div>
    </body>
    <x-footer/>
</html>
