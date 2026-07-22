<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $checkIn = $this->faker->dateTimeBetween('+1 day', '+45 days');
        $checkOut = (clone $checkIn)->modify('+'.$this->faker->numberBetween(1, 4).' days');
        $room = Room::query()->inRandomOrder()->first();
        $nights = max(1, $checkIn->diff($checkOut)->days);

        return [
            'event_id' => Event::factory(), // links to event
            'room_id' => $room?->id,
            'customer_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'number_of_guests' => $this->faker->numberBetween(1, 5),
            'booking_date' => $checkIn->format('Y-m-d'),
            'checkout_date' => $checkOut->format('Y-m-d'),
            'booking_time' => $this->faker->time(),
            'total_price' => $room ? $room->price_min * $nights : null,
            'payment_status' => $this->faker->randomElement(['pending', 'proof_submitted', 'paid']),
            'confirmation_file' => null,
            'notes' => $this->faker->sentence(),
        ];
    }
}
