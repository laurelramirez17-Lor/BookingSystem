<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $staffRoles = ['admin', 'front_desk', 'manager'];

        if (in_array($user->role, $staffRoles, true)) {
            return view('dashboard', [
                'mode' => 'admin',
                'pendingBookings' => Booking::where('booking_status', 'pending')->count(),
                'confirmedBookings' => Booking::where('booking_status', 'confirmed')->count(),
                'cancelledBookings' => Booking::whereIn('booking_status', ['cancelled', 'rejected'])->count(),
                'totalUsers' => User::count(),
                'totalCustomers' => User::where('role', 'customer')->count(),
                'totalRooms' => Room::count(),
                'occupiedRooms' => Room::whereHas('bookings', fn ($query) => $query
                    ->whereIn('booking_status', ['pending', 'confirmed'])
                    ->whereDate('booking_date', '<=', today())
                    ->whereDate('checkout_date', '>', today()))->count(),
                'availableRooms' => Room::query()->when(Schema::hasColumn('rooms', 'availability_status'), fn ($query) => $query->where('availability_status', 'available'))->whereDoesntHave('bookings', fn ($query) => $query
                    ->whereIn('booking_status', ['pending', 'confirmed'])
                    ->whereDate('booking_date', '<=', today())
                    ->whereDate('checkout_date', '>', today()))->count(),
                'totalRevenue' => Booking::whereIn('booking_status', ['confirmed', 'completed'])->sum('total_price'),
                'latestBookings' => Booking::with(['room', 'user'])->latest()->take(6)->get(),
                'latestCustomers' => User::where('role', 'customer')->latest()->take(6)->get(),
                'rooms' => Room::latest()->take(6)->get(),
            ]);
        }

        return view('dashboard', [
            'mode' => 'customer',
            'rooms' => Room::latest()->get(),
            'myBookings' => Booking::with('room')
                ->where('user_id', $user->id)
                ->latest()
                ->get(),
            'amenities' => [
                'Concierge assistance',
                'High-speed Wi-Fi',
                'Breakfast service',
                'Premium room service',
                'Secure parking',
                'Event and suite reservations',
            ],
        ]);
    }

    /** Lightweight JSON search used by the admin dashboard. */
    public function customerSearch(Request $request)
    {
        $term = trim((string) $request->query('q'));
        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $customers = Booking::with('room')
            ->where(function ($query) use ($term) {
                $query->where('customer_name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('booking_reference', 'like', "%{$term}%");
            })
            ->latest()->limit(40)->get()
            ->groupBy(fn (Booking $booking) => strtolower($booking->email ?: $booking->customer_name))
            ->take(8);

        return response()->json($customers->map(fn ($customerBookings) => [
            'name' => $customerBookings->first()->customer_name,
            'email' => $customerBookings->first()->email,
            'bookings' => $customerBookings->take(5)->map(fn (Booking $booking) => [
                'reference' => $booking->booking_reference,
                'room' => $booking->room?->name ?? 'Room not assigned',
                'status' => $booking->bookingStatusLabel(),
                'dates' => $booking->booking_date?->format('M j, Y').' – '.$booking->checkout_date?->format('M j, Y'),
            ]),
        ])->values());
    }
}
