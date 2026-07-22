<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CustomerBookingController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create()
    {
        $rooms = Room::all();

        return view('customer.book.create', compact('rooms'));
    }

    public function createForRoom(Room $room)
    {
        $selectedRoom = $room;

        return view('customer.book.create', [
            'selectedRoom' => $selectedRoom,
        ]);
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'room_id' => 'required|exists:rooms,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:booking_date',
            'booking_time' => 'nullable',
            'confirmation_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'notes' => 'nullable|string',
        ]);

        // Set a default booking time if none is provided
        if (empty($validated['booking_time'])) {
            $validated['booking_time'] = '00:00:00';
        }

        $room = Room::findOrFail($validated['room_id']);

        if ($validated['number_of_guests'] > $room->max_guests) {
            throw ValidationException::withMessages([
                'number_of_guests' => "This room can only accommodate {$room->max_guests} guests.",
            ]);
        }

        if ($room && $this->roomIsUnavailable($room->id, $validated['booking_date'], $validated['checkout_date'])) {
            throw ValidationException::withMessages([
                'booking_date' => 'This room is already reserved for the selected dates. Please choose different dates.',
            ]);
        }

        $nights = $this->numberOfNights($validated['booking_date'], $validated['checkout_date']);
        $validated['total_price'] = $room ? $room->price_min * $nights : null;
        $validated['payment_status'] = $request->hasFile('confirmation_file') ? 'proof_submitted' : 'pending';
        $validated['booking_status'] = 'pending';
        $validated['user_id'] = $request->user()->id;
        // Bookings always use the verified account email, not a user-editable form value.
        $validated['customer_name'] = $request->user()->name;
        $validated['email'] = $request->user()->email;

        // Upload confirmation file
        if ($request->hasFile('confirmation_file')) {
            $validated['confirmation_file'] = $request->file('confirmation_file')
                ->store('bookings', 'public');
        }

        // Save booking
        $booking = Booking::create($validated);

        // Redirect to summary page
        return redirect()->route('customer.book.summary', $booking);
    }

    public function availability(Request $request)
    {
        $request->validate(['room_id' => 'nullable|exists:rooms,id']);

        $bookings = Booking::query()
            ->when($request->room_id, fn ($query, $roomId) => $query->where('room_id', $roomId))
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->whereNotNull('room_id')
            ->get(['id', 'room_id', 'booking_date', 'checkout_date']);

        return response()->json($bookings->map(fn (Booking $booking) => [
            'id' => $booking->id,
            'title' => 'Unavailable',
            'start' => $booking->booking_date->toDateString(),
            // FullCalendar treats the end as exclusive, which matches hotel check-out dates.
            'end' => $booking->checkout_date?->toDateString() ?? $booking->booking_date->copy()->addDay()->toDateString(),
            'display' => 'background',
            'color' => '#dc2626',
        ]));
    }

    /**
     * Display booking summary.
     */
    public function summary(Booking $booking)
    {
        abort_unless($this->canAccessBooking($booking, request()->user()), 403);
        $booking->load(['event', 'room']);

        return view('customer.book.summary', compact('booking'));
    }

    public function verify(string $bookingReference)
    {
        $booking = Booking::with(['event', 'room'])
            ->where('booking_reference', $bookingReference)
            ->firstOrFail();

        return view('customer.book.verify', compact('booking'));
    }

    public function proof(Booking $booking)
    {
        $path = $this->proofPath($booking);

        return response()->file($path);
    }

    public function downloadProof(Booking $booking)
    {
        $path = $this->proofPath($booking);

        return response()->download($path, $booking->uploadedFileName());
    }

    private function proofPath(Booking $booking): string
    {
        $file = $booking->uploadedFile();

        abort_unless($file, 404);

        if (Storage::disk('public')->exists($file)) {
            return Storage::disk('public')->path($file);
        }

        $legacyPath = public_path($file);
        abort_unless(is_file($legacyPath), 404);

        return $legacyPath;
    }

    private function numberOfNights(string $checkIn, string $checkOut): int
    {
        return max(1, (int) Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)));
    }

    private function roomIsUnavailable(int $roomId, string $checkIn, string $checkOut): bool
    {
        return Booking::blockingRoomDates($roomId, $checkIn, $checkOut)
            ->exists();
    }

    private function canAccessBooking(Booking $booking, $user): bool
    {
        return in_array($user->role, ['admin', 'front_desk', 'manager'], true)
            || $booking->user_id === $user->id
            || (! $booking->user_id && $booking->email === $user->email);
    }

}
