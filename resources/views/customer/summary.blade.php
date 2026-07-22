@extends('layouts.app')

@section('content')

<style>
    .summary-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
    }

    .summary-card {
        width: 100%;
        max-width: 820px;
        background: rgba(10,10,10,.78);
        border: 1px solid rgba(255,215,0,.25);
        border-radius: 8px;
        box-shadow: 0 30px 80px rgba(0,0,0,.75);
        padding: 40px;
    }

    .summary-title {
        color: #FFD700;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    .info-row {
        padding: 14px 0;
        border-bottom: 1px solid rgba(255,215,0,.12);
    }

    .info-label {
        color: #FFD700;
        display: block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .info-value {
        color: #f5f5f5;
        margin-top: 4px;
    }

    .preview-img {
        width: 220px;
        max-width: 100%;
        border-radius: 8px;
        border: 1px solid rgba(255,215,0,.28);
        margin-top: 12px;
    }

    .summary-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 26px;
    }

    .summary-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 18px;
        border: 1px solid rgba(255,215,0,.35);
        border-radius: 999px;
        color: #FFD700;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-decoration: none;
    }

    .summary-link.primary {
        background: linear-gradient(135deg,#FFD700,#B8860B);
        color: #111;
        border: 0;
    }
</style>

<div class="summary-page">
    <div class="summary-card">
        <h2 class="summary-title">Booking Confirmation</h2>

        <div class="info-row">
            <span class="info-label">Event</span>
            <div class="info-value">{{ $booking->event->name ?? 'N/A' }}</div>
        </div>

        <div class="info-row">
            <span class="info-label">Guest</span>
            <div class="info-value">{{ $booking->customer_name }}</div>
        </div>

        <div class="info-row">
            <span class="info-label">Email</span>
            <div class="info-value">{{ $booking->email }}</div>
        </div>

        <div class="info-row">
            <span class="info-label">Stay</span>
            <div class="info-value">{{ $booking->booking_date }} to {{ $booking->checkout_date ?? 'N/A' }}</div>
        </div>

        @if($booking->notes)
            <div class="info-row">
                <span class="info-label">Special Requests</span>
                <div class="info-value">{{ $booking->notes }}</div>
            </div>
        @endif

        @if($booking->uploadedFile())
            <div class="info-row">
                <span class="info-label">Uploaded Proof</span>

                @if($booking->uploadedFileIsImage())
                    <a href="{{ route('bookings.proof.view', $booking) }}" target="_blank">
                        <img src="{{ route('bookings.proof.view', $booking) }}" class="preview-img" alt="Uploaded proof">
                    </a>
                @else
                    <div class="info-value">{{ $booking->uploadedFileName() }}</div>
                @endif

                <div class="summary-actions">
                    <a href="{{ route('bookings.proof.view', $booking) }}" class="summary-link" target="_blank">View File</a>
                    <a href="{{ route('bookings.proof.download', $booking) }}" class="summary-link">Download</a>
                </div>
            </div>
        @endif

        <div class="summary-actions">
            <a href="{{ route('customer.book.create') }}" class="summary-link primary">Book Another</a>
        </div>
    </div>
</div>

@endsection
