@extends('layouts.app')

@section('content')

<style>
    .verify-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
    }

    .verify-card {
        width: 100%;
        max-width: 760px;
        background: rgba(10,10,10,.82);
        border: 1px solid rgba(255,215,0,.28);
        border-radius: 8px;
        box-shadow: 0 28px 80px rgba(0,0,0,.68);
        overflow: hidden;
    }

    .verify-header {
        padding: 24px;
        background: linear-gradient(90deg,#FFD700,#B8860B);
        color: #111;
        text-align: center;
        font-weight: 900;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .verify-body {
        padding: 34px;
    }

    .verify-id {
        color: #FFD700;
        font-size: 26px;
        font-weight: 900;
        letter-spacing: 2px;
        margin-bottom: 18px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        gap: 14px;
        padding: 13px 0;
        border-bottom: 1px solid rgba(255,255,255,.09);
    }

    .label {
        color: #FFD700;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .value {
        color: #fff;
        font-weight: 700;
    }

    @media (max-width: 640px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 4px;
        }
    }
</style>

<div class="verify-page">
    <div class="verify-card">
        <div class="verify-header">Verified ARAUM Booking</div>

        <div class="verify-body">
            <div class="verify-id">{{ $booking->booking_reference }}</div>

            <div class="info-row">
                <div class="label">Guest</div>
                <div class="value">{{ $booking->customer_name }}</div>
            </div>

            <div class="info-row">
                <div class="label">Room / Suite</div>
                <div class="value">{{ $booking->roomName() }}</div>
            </div>

            <div class="info-row">
                <div class="label">Stay Dates</div>
                <div class="value">{{ optional($booking->booking_date)->format('M d, Y') }} to {{ optional($booking->checkout_date)->format('M d, Y') }}</div>
            </div>

            <div class="info-row">
                <div class="label">Guests</div>
                <div class="value">{{ $booking->number_of_guests }}</div>
            </div>

            <div class="info-row">
                <div class="label">Nights</div>
                <div class="value">{{ $booking->numberOfNights() }}</div>
            </div>

            <div class="info-row">
                <div class="label">Total Price</div>
                <div class="value">{{ $booking->formattedTotalPrice() }}</div>
            </div>

            <div class="info-row">
                <div class="label">Payment Status</div>
                <div class="value">{{ $booking->paymentStatusLabel() }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
