<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Impressum</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-white via-red-200 to-white dark:bg-gradient-to-br dark:from-neutral-900 dark:via-red-900 dark:to-neutral-900 min-h-screen flex flex-col justify-between">
        <x-navbar/>

        <main class="flex-1 py-12 px-4">
            <div class="max-w-3xl mx-auto bg-white/70 dark:bg-neutral-900/60 backdrop-blur-md rounded-3xl shadow-2xl border border-white/10 p-6 md:p-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-400 to-yellow-400 mb-8">
                    Impressum
                </h1>

                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-8">Angaben gemäß § 5 DDG (Digitale-Dienste-Gesetz)</p>

                <div class="space-y-8 text-neutral-800 dark:text-neutral-200 leading-relaxed">
                    <section>
                        <p class="font-semibold">Islamische Denkfabrik e.V.</p>
                        <p>Gladbacher Str. 127</p>
                        <p>47805 Krefeld</p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">Vertreten durch</h2>
                        <p>Merdan Kilic (1. Vorsitzender)</p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">Kontakt</h2>
                        <p>E-Mail: <a href="mailto:info@islamischedenkfabrik.de" class="text-red-600 dark:text-red-400 hover:underline">info@islamischedenkfabrik.de</a></p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">Registereintrag</h2>
                        <p>Eintragung im Vereinsregister</p>
                        <p>Registergericht: Amtsgericht Krefeld</p>
                        <p>Registernummer: <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-0.5 rounded font-medium">[wird nachgetragen]</span></p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">EU-Streitschlichtung</h2>
                        <p>
                            Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit:
                            <a href="https://ec.europa.eu/consumers/odr/" target="_blank" rel="noopener" class="text-red-600 dark:text-red-400 hover:underline">https://ec.europa.eu/consumers/odr/</a>.
                            Unsere E-Mail-Adresse finden Sie oben im Impressum. Wir sind nicht verpflichtet und nicht bereit, an einem Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.
                        </p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">Haftung für Inhalte</h2>
                        <p>
                            Als Diensteanbieter sind wir gemäß § 7 Abs. 1 DDG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 DDG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
                        </p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">Haftung für Links</h2>
                        <p>
                            Unser Angebot enthält gegebenenfalls Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.
                        </p>
                    </section>

                    <section>
                        <h2 class="font-bold text-lg mb-2">Urheberrecht</h2>
                        <p>
                            Die durch die Vereinsbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Beiträge Dritter sind als solche gekennzeichnet.
                        </p>
                    </section>
                </div>
            </div>
        </main>

        <x-footer/>
    </body>
</html>
