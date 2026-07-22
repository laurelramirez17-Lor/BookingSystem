@extends('layouts.app')

@section('content')

<style>

.booking-section{

    max-width:850px;

    margin:40px auto;

    background:#121212;

    border:1px solid rgba(255,215,0,.18);

    border-radius:20px;

    padding:45px;

    box-shadow:
    0 20px 50px rgba(0,0,0,.45);

}

.booking-title{

    font-family:'Cinzel',serif;

    text-align:center;

    color:#FFD700;

    letter-spacing:4px;

    margin-bottom:10px;

}

.booking-subtitle{

    text-align:center;

    color:#bfbfbf;

    margin-bottom:35px;

}

.form-label{

    color:#FFD700;

    font-weight:500;

}

.form-control,
.form-select{

    background:#1a1a1a;

    border:1px solid rgba(255,215,0,.15);

    color:#fff;

    padding:12px;

}

.form-control:focus,
.form-select:focus{

    background:#1a1a1a;

    color:#fff;

    border-color:#FFD700;

    box-shadow:0 0 10px rgba(255,215,0,.20);

}

.form-control::placeholder{

    color:#999;

}

textarea{

    min-height:120px;

}

.btn-book{

    width:100%;

    margin-top:15px;

    background:linear-gradient(135deg,#FFD700,#B8860B);

    border:none;

    color:#111;

    font-weight:700;

    padding:14px;

    border-radius:50px;

    letter-spacing:2px;

    transition:.35s;

}

.btn-book:hover{

    transform:translateY(-3px);

    background:linear-gradient(135deg,#FFE76A,#C99700);

    box-shadow:0 10px 30px rgba(255,215,0,.35);

}

.alert{

    border:none;

}

</style>

<div class="booking-section">

    <h2 class="booking-title">
        Reserve Your Stay
    </h2>

    <p class="booking-subtitle">
        Complete the reservation form below and begin your luxury experience at <strong style="color:#FFD700;">ARAUM HOTEL</strong>.
    </p>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('customer.book.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-4">

            <label class="form-label">
                Select Suite / Event
            </label>

            <select name="event_id" class="form-select" required>

                <option value="">
                    Choose an Option
                </option>

                @foreach($events as $event)

                    <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>
                        {{ $event->name }} — {{ $event->location }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="row">

            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Full Name
                </label>

                <input
                    type="text"
                    name="customer_name"
                    class="form-control"
                    value="{{ old('customer_name') }}"
                    placeholder="Enter your full name"
                    required>

            </div>

            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required>

            </div>

        </div>

        <div class="mb-4">

            <label class="form-label">
                Number of Guests
            </label>

            <input
                type="number"
                name="number_of_guests"
                class="form-control"
                value="{{ old('number_of_guests', 1) }}"
                min="1"
                max="20"
                required>

        </div>

        <div class="row">

            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Check-in Date
                </label>

                <input
                    type="date"
                    name="booking_date"
                    class="form-control"
                    value="{{ old('booking_date') }}"
                    required>

            </div>

            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Check-out Date
                </label>

                <input
                    type="date"
                    name="checkout_date"
                    class="form-control"
                    value="{{ old('checkout_date') }}"
                    required>

            </div>

        </div>

        <div class="mb-4">

            <label class="form-label">
                Upload Proof of Payment
            </label>

            <input
                type="file"
                name="confirmation_file"
                class="form-control"
                accept="image/*,.pdf">

        </div>

        <div class="mb-4">

            <label class="form-label">
                Special Requests
            </label>

            <textarea
                name="notes"
                class="form-control"
                placeholder="Tell us about your special requests...">{{ old('notes') }}</textarea>

        </div>

        <button class="btn-book">

            CONFIRM RESERVATION

        </button>

    </form>

</div>

@endsection
