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
    
    <main class="flex-1 flex items-center justify-center py-16 px-3">
      <div class="relative w-full max-w-md">
        <section class="relative bg-white/60 dark:bg-neutral-900/60 backdrop-blur-md rounded-3xl shadow-2xl border border-white/10 p-8 space-y-6">
          <div class="text-center">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400">
              Anmelden
            </h2>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
              Melden Sie sich in Ihrem Konto an
            </p>
          </div>

          <!-- Session Status -->
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
              <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                E-Mail-Adresse
              </label>
              <x-text-input id="email" class="block mt-2 w-full rounded-lg border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900/80 dark:text-white focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                Passwort
              </label>
              <x-text-input id="password" class="block mt-2 w-full rounded-lg border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900/80 dark:text-white focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
              <input id="remember_me" type="checkbox" class="h-4 w-4 rounded text-red-600 dark:text-red-500 dark:bg-neutral-900/80 border-neutral-300 dark:border-neutral-600 focus:ring-red-500 dark:focus:ring-red-400 dark:focus:ring-offset-neutral-900" name="remember">
              <label for="remember_me" class="ml-2 block text-sm text-neutral-700 dark:text-neutral-300">
                Anmeldedaten merken
              </label>
            </div>

            <div class="pt-2">
              <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg bg-red-600 dark:bg-red-600 text-white font-semibold shadow hover:bg-red-700 dark:hover:bg-red-700 transition">
                Anmelden
              </button>
            </div>
          </form>
        </section>
      </div>
    </main>
    <x-footer/>
  </body>
</html>
