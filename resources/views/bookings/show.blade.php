@extends('layouts.app')

@section('content')

<style>
    .show-container {
        max-width: 850px;
        margin-top: 50px;
    }

    .show-card {
        background: rgba(10, 10, 10, 0.78);
        border: 1px solid rgba(255,215,0,0.25);
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        backdrop-filter: blur(12px);
        color: #f5f5f5;
        overflow: hidden;
    }

    .show-header {
        background: linear-gradient(90deg,#FFD700,#B8860B);
        padding: 18px;
        color: #111;
        font-weight: 800;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .show-body {
        padding: 30px;
    }

    .info-box {
        margin-bottom: 12px;
        padding: 12px;
        background: rgba(255,255,255,0.05);
        border-left: 3px solid #FFD700;
        border-radius: 8px;
    }

    .label {
        font-size: 12px;
        text-transform: uppercase;
        color: #FFD700;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .value {
        display: block;
        margin-top: 3px;
        font-size: 15px;
        color: #f5f5f5;
    }

    .preview-img {
        margin-top: 10px;
        width: 220px;
        border-radius: 10px;
        border: 1px solid rgba(255,215,0,0.3);
    }

    .proof-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .btn-sm-custom {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: 1px solid rgba(255,215,0,0.35);
        background: transparent;
        color: #FFD700;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .btn-sm-custom:hover {
        background: rgba(255,215,0,0.12);
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-back {
        background: linear-gradient(135deg,#FFD700,#B8860B);
        border: 0;
        color: #111;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        display: block;
        text-align: center;
        margin-top: 20px;
        transition: 0.3s ease;
        text-decoration: none;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255,215,0,0.25);
        color: #111;
    }
</style>

<div class="container show-container">

    <div class="show-card">

        <div class="show-header">
            ARAUM Reservation Details
        </div>

        <div class="show-body">

            <div class="info-box">
                <span class="label">Booking ID</span>
                <span class="value">{{ $booking->booking_reference }}</span>
            </div>

            <div class="info-box">
                <span class="label">Event / Room</span>
                <span class="value">{{ $booking->roomName() }}</span>
            </div>

            <div class="info-box">
                <span class="label">Guest Name</span>
                <span class="value">{{ $booking->customer_name }}</span>
            </div>

            <div class="info-box">
                <span class="label">Email Address</span>
                <span class="value">{{ $booking->email }}</span>
            </div>

            <div class="info-box">
                <span class="label">Number of Guests</span>
                <span class="value">{{ $booking->number_of_guests }}</span>
            </div>

            <div class="info-box">
                <span class="label">Check-in Date</span>
                <span class="value">{{ $booking->booking_date }}</span>
            </div>

            <div class="info-box">
                <span class="label">Check-out Date</span>
                <span class="value">{{ optional($booking->checkout_date)->format('Y-m-d') ?? 'N/A' }}</span>
            </div>

            <div class="info-box">
                <span class="label">Number of Nights</span>
                <span class="value">{{ $booking->numberOfNights() }}</span>
            </div>

            <div class="info-box">
                <span class="label">Total Price</span>
                <span class="value">{{ $booking->formattedTotalPrice() }}</span>
            </div>

            <div class="info-box">
                <span class="label">Payment Status</span>
                <span class="value">{{ $booking->paymentStatusLabel() }}</span>
            </div>

            <div class="info-box">
                <span class="label">Preferred Time</span>
                <span class="value">{{ $booking->booking_time }}</span>
            </div>

            @if($booking->notes)
            <div class="info-box">
                <span class="label">Special Requests</span>
                <span class="value">{{ $booking->notes }}</span>
            </div>
            @endif

            @if($booking->uploadedFile())
            <div class="info-box">
                <span class="label">Uploaded Proof</span>

                @if($booking->uploadedFileIsImage())
                    <a href="{{ route('bookings.proof.view', $booking) }}" target="_blank">
                        <img src="{{ route('bookings.proof.view', $booking) }}" class="preview-img" alt="Uploaded proof">
                    </a>
                @else
                    <span class="value">{{ $booking->uploadedFileName() }}</span>
                @endif

                <div class="proof-actions">
                    <a href="{{ route('bookings.proof.view', $booking) }}" class="btn-sm-custom" target="_blank">
                        View File
                    </a>

                    <a href="{{ route('bookings.proof.download', $booking) }}" class="btn-sm-custom">
                        Download
                    </a>
                </div>
            </div>
            @endif

            <a href="{{ route('bookings.index') }}" class="btn-back">
                Back to Bookings
            </a>

        </div>

    </div>

</div>

@endsection
