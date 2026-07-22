<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $suites = [
            [
                'name' => 'Deluxe King Stay',
                'location' => 'Tower A - City View',
                'description' => 'A refined room package for solo travelers and couples who want comfort with quick concierge access.',
                'capacity' => 2,
            ],
            [
                'name' => 'Premier Twin Stay',
                'location' => 'Tower B - Garden Side',
                'description' => 'A flexible room package with twin bedding, ideal for friends, colleagues, or family guests.',
                'capacity' => 2,
            ],
            [
                'name' => 'Executive Suite Stay',
                'location' => 'Executive Floor',
                'description' => 'A spacious suite reservation with lounge space, breakfast service, minibar, and premium amenities.',
                'capacity' => 3,
            ],
            [
                'name' => 'Family Residence Stay',
                'location' => 'Residence Wing',
                'description' => 'A family-ready room package with extra space, kitchenette, and secure parking access.',
                'capacity' => 6,
            ],
            [
                'name' => 'Presidential Suite Stay',
                'location' => 'Penthouse Level',
                'description' => 'A signature luxury stay with private lounge, personal concierge, and premium dining setup.',
                'capacity' => 4,
            ],
            [
                'name' => 'Grand Ballroom Reservation',
                'location' => 'Grand Ballroom',
                'description' => 'A polished event package for receptions, conferences, and private celebrations.',
                'capacity' => 180,
            ],
        ];

        foreach ($suites as $suite) {
            Event::updateOrCreate(
                ['name' => $suite['name']],
                $suite,
            );
        }
    }
}
