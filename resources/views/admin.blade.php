<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
    <x-navbar/>
        <div class="flex flex-col items-center justify-center flex-1 py-12 px-2">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-4xl">
            <x-admin-card
                url="{{ route('admin.submission.view') }}"
                svg="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                title="Benutzerverwaltung"
                description="Verwalte alle Benutzer und deren Rechte."
            />
            <x-admin-card
                url="{{ route('admin.submission.view') }}"
                svg="M11 16v-5.5A3.5 3.5 0 0 0 7.5 7m3.5 9H4v-5.5A3.5 3.5 0 0 1 7.5 7m3.5 9v4M7.5 7H14m0 0V4h2.5M14 7v3m-3.5 6H20v-6a3 3 0 0 0-3-3m-2 9v4m-8-6.5h1"
                title="Kummerkasteneinträge"
                description="Sieh dir die Einträge aus dem Kummerkasten an."
            />
            <x-admin-card
                url="{{ route('meeting-groups.index') }}"
                svg="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM9 16a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6z"
                title="Sitzungsgruppen"
                description="Verwalte die Sitzungsgruppen."
            />
        </div>
        </div>
    <x-footer/>
  </body>
</html>
