@extends('layouts.app')

@section('content')

<style>

/* FULL PAGE BACKGROUND */
.edit-page{
    min-height:100vh;
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 20px;

    background:
        linear-gradient(rgba(0,0,0,0.78), rgba(0,0,0,0.9)),
        url("https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=2000&q=80");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

/* WRAPPER */
.edit-wrap{
    width:100%;
    max-width:750px;
}

/* LUXURY CARD */
.edit-card{
    background:rgba(10,10,10,0.75);
    border:1px solid rgba(255,215,0,0.25);
    border-radius:25px;
    box-shadow:0 30px 80px rgba(0,0,0,0.85);
    backdrop-filter:blur(18px);
    overflow:hidden;
}

/* GOLD HEADER */
.edit-header{
    padding:25px;
    text-align:center;
    font-weight:800;
    letter-spacing:4px;
    text-transform:uppercase;
    background:linear-gradient(90deg,#FFD700,#B8860B);
    color:#111;
}

/* BODY */
.edit-body{
    padding:45px;
}

/* LABELS */
.form-label{
    font-size:11px;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#FFD700;
    font-weight:600;
    margin-top:15px;
}

/* INPUTS */
.form-control{
    background:transparent;
    border:none;
    border-bottom:1px solid rgba(255,215,0,0.3);
    border-radius:0;
    color:#fff !important;
    padding:12px 5px;
}

.form-control:focus{
    outline:none;
    box-shadow:none;
    border-bottom:1px solid #FFD700;
    background:transparent;
    color:#fff !important;
}

/* PLACEHOLDER */
.form-control::placeholder{
    color:rgba(255,255,255,0.4);
}

/* SELECT FIX */
select.form-control option{
    color:#000;
}

/* FILE INPUT */
input[type="file"]{
    color:#fff;
}

/* AUTOFILL FIX */
input.form-control:-webkit-autofill{
    -webkit-text-fill-color:#fff !important;
    -webkit-box-shadow:0 0 0px 1000px #0a0a0a inset;
}

/* BUTTON */
.btn-booking{
    margin-top:30px;
    width:100%;
    padding:15px;
    border:none;
    border-radius:60px;
    background:linear-gradient(135deg,#FFD700,#B8860B);
    color:#111;
    font-weight:800;
    letter-spacing:3px;
    text-transform:uppercase;
    transition:.3s;
}

.btn-booking:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 40px rgba(255,215,0,0.25);
}

/* MOBILE */
@media(max-width:768px){
    .edit-body{
        padding:30px;
    }
}

</style>

<div class="edit-page">

    <div class="edit-wrap">

        <div class="edit-card">

            <div class="edit-header">
                ARAUM - Edit Reservation
            </div>

            <div class="edit-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.update', $booking) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="form-label">Select Suite / Event</label>
                    <select name="event_id" class="form-control">
                        <option value="">No event</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}"
                                {{ old('event_id', $booking->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label">Room</label>
                    <select name="room_id" class="form-control">
                        <option value="">No specific room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} - PHP {{ number_format($room->price_min) }} to PHP {{ number_format($room->price_max) }}
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label">Guest Name</label>
                    <input type="text"
                           name="customer_name"
                           class="form-control"
                           value="{{ old('customer_name', $booking->customer_name) }}"
                           required>

                    <label class="form-label">Email Address</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $booking->email) }}"
                           required>

                    <label class="form-label">Number of Guests</label>
                    <input type="number"
                           name="number_of_guests"
                           class="form-control"
                           value="{{ old('number_of_guests', $booking->number_of_guests ?? 1) }}"
                           min="1"
                           max="20"
                           required>

                    <label class="form-label">Check-in Date</label>
                    <input type="date"
                           name="booking_date"
                           class="form-control"
                           value="{{ old('booking_date', optional($booking->booking_date)->format('Y-m-d')) }}"
                           required>

                    <label class="form-label">Check-out Date</label>
                    <input type="date"
                           name="checkout_date"
                           class="form-control"
                           value="{{ old('checkout_date', optional($booking->checkout_date)->format('Y-m-d')) }}"
                           required>

                    <label class="form-label">Preferred Time</label>
                    <input type="time"
                           name="booking_time"
                           class="form-control"
                           value="{{ old('booking_time', substr((string) $booking->booking_time, 0, 5)) }}"
                           required>

                    <label class="form-label">Total Price</label>
                    <input type="number"
                           step="0.01"
                           min="0"
                           name="total_price"
                           class="form-control"
                           value="{{ old('total_price', $booking->total_price) }}">

                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-control" required>
                        @foreach(['pending' => 'Pending', 'proof_submitted' => 'Proof Submitted', 'paid' => 'Paid', 'cancelled' => 'Cancelled'] as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_status', $booking->payment_status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label">Replace Confirmation File</label>
                    <input type="file" name="confirmation_file" class="form-control" accept="image/*,.pdf">

                    <button type="submit" class="btn-booking">
                        UPDATE RESERVATION
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
