
    <!DOCTYPE html>
    <html lang="de">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registrieren</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
      </head>
      <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
        <x-navbar/>
        
        <main class="flex-1 flex items-center justify-center py-16 px-3">
          <div class="relative w-full max-w-md">
            <section class="relative bg-white/60 dark:bg-neutral-900/60 backdrop-blur-md rounded-3xl shadow-2xl border border-white/10 p-8 space-y-6">
              <div class="text-center">
                <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400">
                  Registrieren
                </h2>
                <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                  Erstellen Sie einen neuen Account
                </p>
              </div>

              <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                  <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Name
                  </label>
                  <x-text-input id="name" class="block mt-2 w-full rounded-lg border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900/80 dark:text-white focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                  <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    E-Mail-Adresse
                  </label>
                  <x-text-input id="email" class="block mt-2 w-full rounded-lg border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900/80 dark:text-white focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                  <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Passwort
                  </label>
                  <x-text-input id="password" class="block mt-2 w-full rounded-lg border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900/80 dark:text-white focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  <p class="mt-2 text-xs text-neutral-600 dark:text-neutral-400">
                    Mindestens 8 Zeichen, ein Großbuchstabe und eine Zahl erforderlich
                  </p>
                </div>

                <!-- Confirm Password -->
                <div>
                  <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Passwort bestätigen
                  </label>
                  <x-text-input id="password_confirmation" class="block mt-2 w-full rounded-lg border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900/80 dark:text-white focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />
                  <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-2">
                  <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg bg-green-600 dark:bg-green-600 text-white font-semibold shadow hover:bg-green-700 dark:hover:bg-green-700 transition">
                    Registrieren
                  </button>
                </div>

                <div class="text-center">
                  <p class="text-sm text-neutral-600 dark:text-neutral-400">
                    Bereits registriert?
                    <a href="{{ route('login') }}" class="text-red-600 dark:text-red-400 hover:underline font-medium">
                      Hier anmelden
                    </a>
                  </p>
                </div>
              </form>
            </section>
          </div>
        </main>
        <x-footer/>
      </body>
    </html>

