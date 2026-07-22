@extends('layouts.app')

@section('content')

<style>

/* FULL LUXURY BACKGROUND */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background:
        linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.88)),
        url("https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=2000&q=80") center/cover fixed;
    color: #fff;
}

/* MAIN WRAPPER */
.page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    position: relative;
    z-index: 2;
}

/* LUXURY CARD */
.card-lux {
    width: 100%;
    max-width: 900px;
    background: rgba(10, 10, 10, 0.78);
    border: 1px solid rgba(212,175,55,0.35);
    border-radius: 22px;
    backdrop-filter: blur(18px);
    box-shadow: 0 30px 90px rgba(0,0,0,0.85);
    padding: 45px;
}

/* TITLE */
.title {
    font-size: 30px;
    font-weight: 800;
    color: #d4af37;
    text-align: center;
    letter-spacing: 2px;
    margin-bottom: 30px;
    text-transform: uppercase;
}

/* ERROR BOX */
.error-box {
    background: rgba(255, 80, 80, 0.08);
    border: 1px solid rgba(255, 80, 80, 0.3);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 20px;
    color: #ffb3b3;
}

/* FORM LABELS */
.form-label {
    color: #d4af37;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 14px;
    display: block;
}

/* INPUTS */
.form-control {
    width: 100%;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(212,175,55,0.25);
    color: #fff !important;
    border-radius: 12px;
    padding: 12px;
    transition: 0.3s ease;
}

/* INPUT FOCUS */
.form-control:focus {
    border-color: #ffd700;
    box-shadow: 0 0 15px rgba(212,175,55,0.25);
    outline: none;
}

/* FIX DROPDOWN VISIBILITY */
select.form-control option {
    color: #000;
}

/* INPUT HOVER LIFT */
.form-control:hover {
    border-color: rgba(212,175,55,0.5);
}

/* BUTTON */
.btn-gold {
    margin-top: 25px;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #d4af37, #b8860b);
    color: #111;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    cursor: pointer;
    transition: 0.3s ease;
}

/* BUTTON HOVER */
.btn-gold:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(212,175,55,0.25);
}

</style>

<div class="page">

    <div class="card-lux">

        <div class="title">Araum Reservation</div>

        @if ($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- SUITE / EVENT -->
            <label class="form-label">Suite / Event</label>
            <select name="event_id" class="form-control" required>
                <option value="">Select Suite / Event</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">
                        {{ $event->name }}
                    </option>
                @endforeach
            </select>

            <label class="form-label">Room</label>
            <select name="room_id" class="form-control">
                <option value="">No specific room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">
                        {{ $room->name }} - PHP {{ number_format($room->price_min) }} to PHP {{ number_format($room->price_max) }}
                    </option>
                @endforeach
            </select>

            <!-- NAME -->
            <label class="form-label">Guest Name</label>
            <input type="text" name="customer_name" class="form-control" required>

            <!-- EMAIL -->
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>

            <label class="form-label">Number of Guests</label>
            <input type="number" name="number_of_guests" class="form-control" value="1" min="1" max="20" required>

            <!-- DATE -->
            <label class="form-label">Check-in Date</label>
            <input type="date" name="booking_date" class="form-control" required>

            <label class="form-label">Check-out Date</label>
            <input type="date" name="checkout_date" class="form-control">

            <!-- TIME -->
            <label class="form-label">Preferred Time</label>
            <input type="time" name="booking_time" class="form-control">

            <label class="form-label">Total Price</label>
            <input type="number" step="0.01" min="0" name="total_price" class="form-control" placeholder="Leave blank to auto-calculate from selected room">

            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="proof_submitted">Proof Submitted</option>
                <option value="paid">Paid</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <!-- IMAGE -->
            <label class="form-label">Upload Confirmation File</label>
            <input type="file" name="confirmation_file" class="form-control" accept="image/*,.pdf">

            <!-- NOTES -->
            <label class="form-label">Special Requests</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>

            <button type="submit" class="btn-gold">
                Confirm Reservation
            </button>

        </form>

    </div>

</div>

@endsection
