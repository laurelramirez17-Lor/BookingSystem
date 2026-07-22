@extends('layouts.app')

@section('content')

<style>

/* FULL LUXURY BACKGROUND */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background:
        linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.85)),
        url("https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=2000&q=80") center/cover fixed;
    color: #fff;
}

/* PAGE WRAPPER (NO CONTAINER FEEL) */
.page-container {
    padding: 60px 40px;
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-title {
    font-size: 26px;
    font-weight: 800;
    letter-spacing: 3px;
    color: #FFD700;
    text-transform: uppercase;
}

/* ADD BUTTON */
.btn-add {
    background: linear-gradient(135deg, #FFD700, #B8860B);
    border: none;
    color: #111;
    padding: 12px 18px;
    border-radius: 50px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    transition: 0.3s ease;
}

.btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(255,215,0,0.25);
}

/* ALERT */
.alert {
    background: rgba(255,215,0,0.08);
    border: 1px solid rgba(255,215,0,0.3);
    color: #FFD700;
    border-radius: 12px;
}

/* GRID */
.booking-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

/* LUXURY CARD */
.booking-card {
    background: rgba(0, 0, 0, 0.65);
    border: 1px solid rgba(255, 215, 0, 0.25);
    border-radius: 18px;
    padding: 22px;
    backdrop-filter: blur(12px);
    transition: 0.3s ease;
}

.booking-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.7);
    border-color: rgba(255,215,0,0.5);
}

/* TEXT */
.booking-title {
    font-size: 18px;
    font-weight: 700;
    color: #FFD700;
}

.booking-meta,
.booking-line {
    font-size: 13px;
    color: #ddd;
    margin-top: 5px;
}

/* ACTION BUTTONS (ALL GOLD STYLE ONLY) */
.btn-group-actions {
    margin-top: 15px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-sm-custom {
    padding: 7px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    border: 1px solid rgba(255,215,0,0.3);
    background: transparent;
    color: #FFD700;
    transition: 0.3s ease;
}

.btn-sm-custom:hover {
    background: rgba(255,215,0,0.1);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255,215,0,0.15);
}

</style>

<div class="page-container">

    <!-- HEADER -->
    <div class="page-header">

        <div class="page-title">
            ARAUM - Bookings Dashboard
        </div>

        <a href="{{ route('bookings.create') }}" class="btn-add">
            + Add Booking
        </a>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- GRID -->
    <div class="booking-grid">

        @foreach($bookings as $booking)

            <div class="booking-card">

                <div class="booking-title">
                    {{ $booking->customer_name }}
                </div>

                <div class="booking-meta">
                    {{ $booking->event->name ?? 'No Event' }}
                </div>

                <div class="booking-line">
                    {{ $booking->booking_date }} | {{ $booking->booking_time ?? 'No time set' }}
                </div>
                <div class="booking-line">Status: {{ $booking->bookingStatusLabel() }}</div>

                <div class="btn-group-actions">

                    <a href="{{ route('bookings.show', $booking) }}" class="btn-sm-custom">
                        View
                    </a>

                    <a href="{{ route('bookings.edit', $booking) }}" class="btn-sm-custom">
                        Edit
                    </a>

                    @if($booking->booking_status === 'pending')
                        <form action="{{ route('bookings.status', $booking) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="booking_status" value="confirmed">
                            <button type="submit" class="btn-sm-custom">Approve</button>
                        </form>
                        <form action="{{ route('bookings.status', $booking) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="booking_status" value="rejected">
                            <button type="submit" class="btn-sm-custom">Reject</button>
                        </form>
                    @endif

                    @if(in_array($booking->booking_status, ['pending', 'confirmed'], true))
                        <form action="{{ route('bookings.status', $booking) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="booking_status" value="cancelled">
                            <button type="submit" class="btn-sm-custom">Cancel</button>
                        </form>
                    @endif

                    @if($booking->booking_status === 'confirmed')
                        <form action="{{ route('bookings.status', $booking) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="booking_status" value="completed">
                            <button type="submit" class="btn-sm-custom">Complete</button>
                        </form>
                    @endif

                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this reservation from the database?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm-custom">
                            Delete
                        </button>
                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection
