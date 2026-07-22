<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->loadMissing(['event', 'room']);
    }

    public function build(): self
    {
        return $this->subject(($this->booking->booking_status === 'confirmed' ? 'Booking Confirmed' : 'Booking Update').' - '.$this->booking->booking_reference)
            ->view('emails.booking-status')
            ->with(['booking' => $this->booking, 'hotelName' => config('app.name', 'ARAUM Hotel')]);
    }
}
