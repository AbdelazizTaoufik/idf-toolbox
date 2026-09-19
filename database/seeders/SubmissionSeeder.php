<?php

namespace Database\Seeders;

use App\Models\MeetingGroup;
use App\Models\Submission;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $submissions = [
            [
                'title' => 'Mehr Sitzkissen für den Gebetsraum',
                'text' => 'Bei größeren Sitzungen reichen die vorhandenen Sitzkissen nicht für alle Teilnehmer aus. Wäre schön, wenn ein paar mehr angeschafft werden könnten.',
                'meeting_group' => 'Allgemeine Gruppe',
            ],
            [
                'title' => 'Feedback zum Koranunterricht',
                'text' => 'Der Unterricht für Anfänger ist sehr verständlich aufgebaut. Es wäre hilfreich, wenn die Übungsblätter auch vorab digital zur Verfügung gestellt werden könnten.',
                'meeting_group' => 'Koranunterricht für Beginner/Kinder',
            ],
            [
                'title' => 'Uhrzeit der Mädchengruppe',
                'text' => 'Könnte die Sitzung montags eventuell etwas später beginnen? Viele Mädchen kommen wegen der Schule erst kurz nach 17:00 Uhr an.',
                'meeting_group' => 'Gruppe 5.-7.Klasse Mädchen',
            ],
            [
                'title' => 'Vorschlag: Ausflug der Kindergruppe',
                'text' => 'Es wäre schön, einmal im Jahr einen gemeinsamen Ausflug für die Kindergruppen zu organisieren, z.B. in einen Freizeitpark oder ins Museum.',
                'meeting_group' => 'Arabisch für Kinder',
            ],
            [
                'title' => 'Lob für den Lese- und Gesprächszirkel',
                'text' => 'Die Diskussionsrunden sind immer sehr bereichernd. Danke an Ibrahim für die tolle Vorbereitung jede Woche!',
                'meeting_group' => 'Lese- und Gesprächszirkel',
            ],
            [
                'title' => 'Parkplatzsituation samstags',
                'text' => 'An Samstagen mit mehreren Gruppen gleichzeitig ist es sehr eng mit den Parkplätzen. Vielleicht könnte man die Nachbarn um zusätzliche Plätze bitten.',
            ],
            [
                'title' => 'Anregung: Newsletter für Veranstaltungen',
                'text' => 'Ein monatlicher Newsletter mit den anstehenden Terminen und Veranstaltungen würde helfen, nichts zu verpassen.',
            ],
            [
                'title' => 'Beschwerde über Lautstärke im Flur',
                'text' => 'Während der Allgemeinsitzung war es im Flur davor recht laut, wodurch man den Vortrag schlecht verstehen konnte. Vielleicht könnte man dort auf Ruhe hinweisen.',
                'meeting_group' => 'Allgemeinsitzung',
            ],
        ];

        $meetingGroups = MeetingGroup::pluck('id', 'name');

        foreach ($submissions as $submission) {
            Submission::firstOrCreate(
                ['title' => $submission['title']],
                [
                    'text' => $submission['text'],
                    'meeting_group_id' => isset($submission['meeting_group'])
                        ? $meetingGroups->get($submission['meeting_group'])
                        : null,
                ]
            );
        }
    }
}
