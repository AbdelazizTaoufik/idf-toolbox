<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Bestätigung</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
    <x-navbar/>
    
    <main class="flex-1 flex items-center justify-center py-16 px-3">
      <div class="relative w-full max-w-md">
        <section class="relative bg-white/60 dark:bg-neutral-900/60 backdrop-blur-md rounded-3xl shadow-2xl border border-white/10 p-8 space-y-6">
          <div class="text-center">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400">
              Email Bestätigung
            </h2>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
              Bestätigen Sie Ihre E-Mail-Adresse
            </p>
          </div>

          <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <p class="text-sm text-neutral-700 dark:text-neutral-300">
              Vielen Dank für Ihre Registrierung! Bitte bestätigen Sie Ihre E-Mail-Adresse, indem Sie auf den Link klicken, den wir Ihnen gerade gesendet haben. Wenn Sie die E-Mail nicht erhalten haben, können wir Ihnen gerne eine neue senden.
            </p>
          </div>

          @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
              <p class="text-sm font-medium text-green-800 dark:text-green-300">
                ✅ Ein neuer Verifikationslink wurde an Ihre E-Mail-Adresse gesendet!
              </p>
            </div>
          @endif

          <form method="POST" action="{{ route('verification.send') }}" class="pt-2">
            @csrf
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg bg-red-600 dark:bg-red-600 text-white font-semibold shadow hover:bg-red-700 dark:hover:bg-red-700 transition">
              Verifikations-E-Mail erneut senden
            </button>
          </form>

          <div class="text-center">
            <p class="text-xs text-neutral-600 dark:text-neutral-400">
              Sie können sich jederzeit abmelden, indem Sie den Logout-Button in der Navigation verwenden.
            </p>
          </div>
        </section>
      </div>
    </main>
    <x-footer/>
  </body>
</html>
