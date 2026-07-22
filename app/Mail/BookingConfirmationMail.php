<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->loadMissing(['event', 'room']);
    }

    public function build()
    {
        return $this
            ->subject('Hotel Reservation Confirmed - '.$this->booking->booking_reference)
            ->view('emails.booking-confirmation')
            ->with([
                'booking' => $this->booking,
                'hotelName' => config('app.name', 'ARAUM Hotel'),
                'verificationUrl' => route('booking.verify', $this->booking->booking_reference),
                'qrCodeUrl' => 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data='.urlencode(route('booking.verify', $this->booking->booking_reference)),
            ]);
    }
}
