<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $events = Event::orderBy('id')->get();
        $rooms = Room::orderBy('id')->get();

        if ($customers->isEmpty() || $events->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        $reservations = [
            [
                'customer' => 'customer@example.com',
                'event' => 'Deluxe King Stay',
                'room' => 'Deluxe King Room',
                'customer_name' => 'Customer One',
                'number_of_guests' => 2,
                'booking_date' => now()->addDays(2)->toDateString(),
                'checkout_date' => now()->addDays(4)->toDateString(),
                'booking_time' => '14:00:00',
                'payment_status' => 'proof_submitted',
                'notes' => 'Prefers a quiet room away from the elevator.',
            ],
            [
                'customer' => 'guest@example.com',
                'event' => 'Executive Suite Stay',
                'room' => 'Executive Suite',
                'customer_name' => 'Guest Customer',
                'number_of_guests' => 2,
                'booking_date' => now()->addDays(5)->toDateString(),
                'checkout_date' => now()->addDays(7)->toDateString(),
                'booking_time' => '15:30:00',
                'payment_status' => 'paid',
                'notes' => 'Anniversary setup requested.',
            ],
            [
                'customer' => 'maria.santos@example.com',
                'event' => 'Family Residence Stay',
                'room' => 'Family Residence',
                'customer_name' => 'Maria Santos',
                'number_of_guests' => 5,
                'booking_date' => now()->addDays(8)->toDateString(),
                'checkout_date' => now()->addDays(11)->toDateString(),
                'booking_time' => '13:00:00',
                'payment_status' => 'pending',
                'notes' => 'Needs extra pillows and parking.',
            ],
            [
                'customer' => 'james.cruz@example.com',
                'event' => 'Premier Twin Stay',
                'room' => 'Premier Twin Room',
                'customer_name' => 'James Cruz',
                'number_of_guests' => 2,
                'booking_date' => now()->addDays(10)->toDateString(),
                'checkout_date' => now()->addDays(12)->toDateString(),
                'booking_time' => '16:00:00',
                'payment_status' => 'proof_submitted',
                'notes' => 'Late check-in due to flight schedule.',
            ],
            [
                'customer' => 'sofia.reyes@example.com',
                'event' => 'Grand Ballroom Reservation',
                'room' => 'Presidential Suite',
                'customer_name' => 'Sofia Reyes',
                'number_of_guests' => 4,
                'booking_date' => now()->addDays(18)->toDateString(),
                'checkout_date' => now()->addDays(18)->toDateString(),
                'booking_time' => '10:00:00',
                'payment_status' => 'pending',
                'notes' => 'Corporate event inquiry with projector setup.',
            ],
        ];

        foreach ($reservations as $reservation) {
            $event = Event::where('name', $reservation['event'])->first() ?? $events->first();
            $room = Room::where('name', $reservation['room'])->first() ?? $rooms->first();
            $nights = max(1, (int) Carbon::parse($reservation['booking_date'])->diffInDays(Carbon::parse($reservation['checkout_date'])));

            Booking::updateOrCreate(
                [
                    'email' => $reservation['customer'],
                    'booking_date' => $reservation['booking_date'],
                    'event_id' => $event->id,
                ],
                [
                    'event_id' => $event->id,
                    'room_id' => $room->id,
                    'customer_name' => $reservation['customer_name'],
                    'email' => $reservation['customer'],
                    'number_of_guests' => $reservation['number_of_guests'],
                    'booking_date' => $reservation['booking_date'],
                    'checkout_date' => $reservation['checkout_date'],
                    'booking_time' => $reservation['booking_time'],
                    'total_price' => $room->price_min * $nights,
                    'payment_status' => $reservation['payment_status'],
                    'confirmation_file' => null,
                    'notes' => $reservation['notes'],
                ],
            );
        }
    }
}
