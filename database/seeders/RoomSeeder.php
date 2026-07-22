<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Deluxe King Room',
                'description' => 'King bed, city view, breakfast service, Wi-Fi, smart TV, hot shower, and work desk.',
                'price_min' => 3500,
                'price_max' => 4800,
                'image' => null,
            ],
            [
                'name' => 'Premier Twin Room',
                'description' => 'Two premium beds, lounge chair, complimentary toiletries, Wi-Fi, and room service access.',
                'price_min' => 4200,
                'price_max' => 5600,
                'image' => null,
            ],
            [
                'name' => 'Executive Suite',
                'description' => 'Separate living area, minibar, bathtub, concierge assistance, breakfast, and premium linens.',
                'price_min' => 7200,
                'price_max' => 9500,
                'image' => null,
            ],
            [
                'name' => 'Family Residence',
                'description' => 'Two-bedroom family layout with kitchenette, dining area, secure parking, and extra bedding.',
                'price_min' => 8800,
                'price_max' => 12500,
                'image' => null,
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'Top-floor suite with private lounge, luxury bath, personal concierge, dining setup, and skyline view.',
                'price_min' => 18000,
                'price_max' => 26000,
                'image' => null,
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['name' => $room['name']],
                $room,
            );
        }
    }
}
