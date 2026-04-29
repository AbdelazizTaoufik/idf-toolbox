<?php

namespace Database\Seeders;

use App\Models\MeetingGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'name' => 'Vorstand',
                'description' => 'Vorstandssitzungen der Islamischen Denkfabrik',
                'weekday' => 'monday',
                'time' => '19:00',
                'is_public' => true
            ],
            [
                'name' => 'Bildung',
                'description' => 'Bildungsgruppe und Veranstaltungen',
                'weekday' => 'wednesday',
                'time' => '18:30',
                'is_public' => true
            ],
            [
                'name' => 'Öffentlichkeitsarbeit',
                'description' => 'Kommunikation und Marketing',
                'weekday' => 'thursday',
                'time' => '19:30',
                'is_public' => true
            ],
            [
                'name' => 'Projektgruppe',
                'description' => 'Spezielle Projektgruppe',
                'weekday' => null,
                'time' => null,
                'is_public' => false
            ],
            [
                'name' => 'Sonstiges',
                'description' => 'Andere Sitzungsgruppen',
                'weekday' => null,
                'time' => null,
                'is_public' => true
            ]
        ];

        foreach ($groups as $group) {
            MeetingGroup::create($group);
        }
    }
}
