<?php

namespace Database\Seeders;

use App\Models\MeetingGroup;
use Illuminate\Database\Seeder;

class MeetingGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'name' => 'Gruppe 5.-7.Klasse Mädchen',
                'description' => 'Leitung: Isra, Beyza (17:00 – 18:30 Uhr)',
                'weekday' => 'monday',
                'time' => '17:00',
                'is_public' => true
            ],
            [
                'name' => 'Koranunterricht für Beginner/Kinder',
                'description' => 'Leitung: Sayfullah, Torben (19:00 – 20:00 Uhr)',
                'weekday' => 'wednesday',
                'time' => '19:00',
                'is_public' => true
            ],
            [
                'name' => 'Koran und Dikr',
                'description' => 'Leitung: Sayfullah, Mohamed (20:00 – 21:30 Uhr)',
                'weekday' => 'wednesday',
                'time' => '20:00',
                'is_public' => true
            ],
            [
                'name' => 'Lese- und Gesprächszirkel',
                'description' => 'Leitung: Ibrahim',
                'weekday' => 'thursday',
                'time' => '19:00',
                'is_public' => true
            ],
            [
                'name' => 'Allgemeine Gruppe',
                'description' => 'Leitung: Betül',
                'weekday' => 'thursday',
                'time' => '19:00',
                'is_public' => true
            ],
            [
                'name' => 'Gruppe Aischa',
                'description' => 'Leitung: Jinane (16:30 – 18:30 Uhr)',
                'weekday' => 'friday',
                'time' => '16:30',
                'is_public' => true
            ],
            [
                'name' => 'Gruppe ʿAlī ibn Abī Tālib',
                'description' => 'Leitung: Merdan, Mücahid (17:15 – 19:00 Uhr)',
                'weekday' => 'friday',
                'time' => '17:15',
                'is_public' => true
            ],
            [
                'name' => 'Arabisch für Kinder',
                'description' => 'Leitung: Ibtissam (10:00 – 12:30 Uhr)',
                'weekday' => 'saturday',
                'time' => '10:00',
                'is_public' => true
            ],
            [
                'name' => 'Gruppe 8-10 Klasse Jungs',
                'description' => 'Leitung: Faruk, Enes',
                'weekday' => 'saturday',
                'time' => '18:00',
                'is_public' => true
            ],
            [
                'name' => 'Allgemeinsitzung',
                'description' => 'Leitung: Ayoub',
                'weekday' => 'saturday',
                'time' => '19:00',
                'is_public' => true
            ],
            [
                'name' => 'Gruppe 5-7 Klasse Jungs',
                'description' => 'Leitung: Hakan, Tolga, Torben (16:00 – 18:00 Uhr)',
                'weekday' => 'sunday',
                'time' => '16:00',
                'is_public' => true
            ]
        ];

        foreach ($groups as $group) {
            MeetingGroup::create($group);
        }
    }
}
