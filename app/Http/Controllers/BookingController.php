<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Throwable;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['event', 'room', 'user'])
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }


    public function create()
    {
        $events = Event::all();
        $rooms = Room::all();

        return view('bookings.create', compact('events', 'rooms'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'room_id' => 'required|exists:rooms,id',
            'customer_name' => 'required|string',
            'email' => 'required|email',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:booking_date',
            'booking_time' => 'nullable',
            'total_price' => 'nullable|numeric|min:0',
            'payment_status' => 'required|string|in:pending,proof_submitted,paid,cancelled',
            'confirmation_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'notes' => 'nullable'
        ]);


        $data = $request->only([
            'event_id',
            'room_id',
            'customer_name',
            'email',
            'number_of_guests',
            'booking_date',
            'checkout_date',
            'booking_time',
            'total_price',
            'payment_status',
            'notes'
        ]);


        $data['booking_time'] ??= '00:00:00';


        $room = Room::findOrFail($data['room_id']);


        $this->ensureRoomCanBeBooked(
            $room,
            $data['booking_date'],
            $data['checkout_date'],
            (int)$data['number_of_guests']
        );


        if (!$data['total_price'] && $data['checkout_date']) {

            $data['total_price'] =
                $room->price_min *
                $this->numberOfNights(
                    $data['booking_date'],
                    $data['checkout_date']
                );
        }


        if ($request->hasFile('confirmation_file')) {

            $data['confirmation_file'] =
                $request->file('confirmation_file')
                ->store('bookings','public');

        }


        Booking::create($data);


        return redirect()
            ->route('bookings.index')
            ->with('success','Booking created successfully!');
    }



    public function show(Booking $booking)
    {
        $booking->load(['event','room','user']);

        return view('bookings.show',compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', [
            'booking' => $booking,
            'events' => Event::all(),
            'rooms' => Room::all(),
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'room_id' => 'nullable|exists:rooms,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'number_of_guests' => 'required|integer|min:1|max:20',
            // Administrators may need to correct an existing historical booking.
            'booking_date' => 'required|date',
            'checkout_date' => 'required|date|after:booking_date',
            'booking_time' => 'nullable|date_format:H:i',
            'total_price' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,proof_submitted,paid,cancelled',
            'confirmation_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        if (! ($data['room_id'] ?? null) && ! ($data['event_id'] ?? null)) {
            throw ValidationException::withMessages([
                'room_id' => 'Select a room or an event for this reservation.',
            ]);
        }

        $room = ($data['room_id'] ?? null) ? Room::findOrFail($data['room_id']) : null;

        if ($room) {
            $this->ensureRoomCanBeBooked(
                $room,
                $data['booking_date'],
                $data['checkout_date'],
                (int) $data['number_of_guests'],
                $booking->id
            );

            if ($data['total_price'] === null) {
                $data['total_price'] = $room->price_min * $this->numberOfNights(
                    $data['booking_date'],
                    $data['checkout_date']
                );
            }
        }

        $data['booking_time'] ??= '00:00:00';

        if ($request->hasFile('confirmation_file')) {
            if ($booking->confirmation_file) {
                Storage::disk('public')->delete($booking->confirmation_file);
            }

            $data['confirmation_file'] = $request->file('confirmation_file')->store('bookings', 'public');
        }

        $booking->update($data);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }



    public function customerHistory(User $user)
    {
        $bookings = $user->bookings()
            ->with(['event','room'])
            ->latest()
            ->get();


        return view(
            'bookings.customer-history',
            compact('user','bookings')
        );
    }



    public function updateStatus(Request $request, Booking $booking)
    {

        $request->validate([
            'booking_status'
            =>
            'required|in:confirmed,rejected,cancelled,completed,pending'
        ]);


        $oldStatus = $booking->booking_status;


        $booking->update([
            'booking_status'
            =>
            $request->booking_status
        ]);



        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL ONLY AFTER ADMIN APPROVES
        |--------------------------------------------------------------------------
        */


        if(
            $oldStatus !== 'confirmed'
            &&
            $booking->booking_status === 'confirmed'
        ){

            try {


                // Load customer relationship
                $booking->load('user','room');



                // Send to customer's email
                $customerEmail =
                    $booking->user->email
                    ?? $booking->email;



                Mail::to($customerEmail)
                    ->send(
                        new BookingConfirmationMail($booking)
                    );



                Log::info(
                    'Booking confirmation email sent.',
                    [
                        'booking_id'=>$booking->id,
                        'email'=>$customerEmail
                    ]
                );


            }
            catch(Throwable $exception){


                Log::error(
                    'Booking confirmation email failed.',
                    [
                        'booking_id'=>$booking->id,
                        'error'=>$exception->getMessage()
                    ]
                );

            }

        }



        return back()
            ->with(
                'success',
                'Booking status updated successfully.'
            );

    }




    public function destroy(Booking $booking)
    {

        if($booking->confirmation_file){

            Storage::disk('public')
                ->delete($booking->confirmation_file);

        }


        $booking->delete();


        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Booking deleted successfully!'
            );

    }




    private function numberOfNights(
        string $checkIn,
        string $checkOut
    ): int
    {

        return max(
            1,
            Carbon::parse($checkIn)
            ->diffInDays(
                Carbon::parse($checkOut)
            )
        );

    }




    private function ensureRoomCanBeBooked(
        Room $room,
        string $checkIn,
        string $checkOut,
        int $guests,
        ?int $ignoreBookingId = null
    ): void
    {


        if(
            Schema::hasColumn(
                'rooms',
                'availability_status'
            )
            &&
            $room->availability_status !== 'available'
        ){

            throw ValidationException::withMessages([
                'room_id'=>
                'This room is not available.'
            ]);

        }



        if($guests > $room->max_guests){

            throw ValidationException::withMessages([
                'number_of_guests'=>
                "This room can only accommodate {$room->max_guests} guests."
            ]);

        }



        $overlap =
            Booking::blockingRoomDates(
                $room->id,
                $checkIn,
                $checkOut
            )
            ->when(
                $ignoreBookingId,
                fn($query)=>
                $query->whereKeyNot($ignoreBookingId)
            )
            ->exists();



        if($overlap){

            throw ValidationException::withMessages([
                'booking_date'=>
                'This room is already reserved for the selected dates.'
            ]);

        }

    }

}
