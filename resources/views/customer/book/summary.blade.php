@extends('layouts.app')

@section('content')

<style>

/* FULL SCREEN PAGE */
.summary-page{
    min-height:100vh;
    width:100%;
    background:
        radial-gradient(circle at top, #111 0%, #000 70%);
    color:#fff;
    padding:0;
    margin:0;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* FULL WIDTH WRAPPER (NOT A CONTAINER) */
.summary-wrap{
    width:100%;
    max-width:1100px;
    padding:60px 40px;
}

/* LUXURY CARD WITHOUT "CONTAINER FEEL" */
.summary-card{
    width:100%;
    background:rgba(10,10,10,0.78);
    border:1px solid rgba(255,215,0,0.25);
    border-radius:25px;
    backdrop-filter:blur(16px);
    box-shadow:0 30px 80px rgba(0,0,0,0.8);
    overflow:hidden;
}

/* GOLD HEADER */
.summary-header{
    padding:30px;
    text-align:center;
    font-size:18px;
    font-weight:700;
    letter-spacing:4px;
    text-transform:uppercase;
    color:#111;
    background:linear-gradient(90deg,#FFD700,#B8860B);
}

/* BODY */
.summary-body{
    padding:50px;
}

/* INFO ROW STYLE */
.info-box{
    padding:18px 0;
    border-bottom:1px solid rgba(255,215,0,0.08);
}

.label{
    font-size:11px;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#FFD700;
}

.value{
    margin-top:6px;
    font-size:16px;
    color:#f5f5f5;
}

/* IMAGE */
.preview-img{
    width:100%;
    max-width:340px;
    margin-top:12px;
    border-radius:14px;
    border:1px solid rgba(255,215,0,0.3);
    transition:.3s;
    cursor:pointer;
}

.preview-img:hover{
    transform:scale(1.04);
    box-shadow:0 15px 40px rgba(255,215,0,0.15);
}

/* BUTTON */
.btn-luxury{
    margin-top:35px;
    width:100%;
    padding:15px;
    border:none;
    border-radius:60px;
    background:linear-gradient(135deg,#FFD700,#B8860B);
    color:#111;
    font-weight:800;
    letter-spacing:3px;
    transition:.3s;
}

.btn-luxury:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 40px rgba(255,215,0,0.25);
}

.proof-actions{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    margin-top:16px;
}

.proof-link{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:42px;
    padding:0 18px;
    border:1px solid rgba(255,215,0,0.35);
    border-radius:999px;
    color:#FFD700;
    font-size:12px;
    font-weight:800;
    letter-spacing:2px;
    text-transform:uppercase;
    text-decoration:none;
    transition:.3s;
}

.proof-link:hover{
    background:rgba(255,215,0,0.1);
    color:#fff;
    transform:translateY(-2px);
}

/* MOBILE */
@media(max-width:768px){
    .summary-wrap{
        padding:30px 15px;
    }

    .summary-body{
        padding:30px;
    }
}

</style>

<div class="summary-page">

    <div class="summary-wrap">

        <div class="summary-card">

            <div class="summary-header">
                ARAUM - BOOKING SUMMARY
            </div>

            <div class="summary-body">

                <div class="info-box">
                    <div class="label">Reservation Status</div>
                    <div class="value">Submitted for admin review. Your booking will be confirmed after payment is checked.</div>
                </div>

                <div class="info-box">
                    <div class="label">Booking ID</div>
                    <div class="value">{{ $booking->booking_reference }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Guest Name</div>
                    <div class="value">{{ $booking->customer_name }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Email Address</div>
                    <div class="value">{{ $booking->email }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Suite / Event</div>
                    <div class="value">{{ $booking->roomName() }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Location</div>
                    <div class="value">{{ $booking->event->location ?? 'N/A' }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Check-in Date</div>
                    <div class="value">{{ $booking->booking_date }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Check-out Date</div>
                    <div class="value">{{ optional($booking->checkout_date)->format('Y-m-d') ?? 'N/A' }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Number of Guests</div>
                    <div class="value">{{ $booking->number_of_guests }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Number of Nights</div>
                    <div class="value">{{ $booking->numberOfNights() }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Total Price</div>
                    <div class="value">{{ $booking->formattedTotalPrice() }}</div>
                </div>

                <div class="info-box">
                    <div class="label">Payment Status</div>
                    <div class="value">{{ $booking->paymentStatusLabel() }}</div>
                </div>

                @if($booking->notes)
                <div class="info-box">
                    <div class="label">Special Requests</div>
                    <div class="value">{{ $booking->notes }}</div>
                </div>
                @endif

                @if($booking->uploadedFile())
                <div class="info-box">
                    <div class="label">Uploaded File</div>

                    @if($booking->uploadedFileIsImage())
                        <a href="{{ route('bookings.proof.view', $booking) }}" target="_blank">
                            <img
                                src="{{ route('bookings.proof.view', $booking) }}"
                                class="preview-img"
                                alt="Uploaded payment proof"
                            >
                        </a>
                    @else
                        <div class="value">{{ $booking->uploadedFileName() }}</div>
                    @endif

                    <div class="proof-actions">
                        <a href="{{ route('bookings.proof.view', $booking) }}" class="proof-link" target="_blank">
                            View File
                        </a>

                        <a href="{{ route('bookings.proof.download', $booking) }}" class="proof-link">
                            Download
                        </a>
                    </div>
                </div>
                @endif

                <a href="{{ route('customer.book.create') }}">
                    <button class="btn-luxury">
                        BOOK ANOTHER EXPERIENCE
                    </button>
                </a>

            </div>

        </div>

    </div>

</div>

{{-- IMAGE MODAL --}}
@if($booking->uploadedFileIsImage())

<div class="modal fade" id="imageModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content bg-dark text-light" style="border:1px solid #FFD700; border-radius:15px;">

            <div class="modal-header border-0">
                <h5 class="modal-title text-warning">ARAUM • DOCUMENT PREVIEW</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="{{ route('bookings.proof.view', $booking) }}" class="img-fluid rounded">
            </div>

        </div>

    </div>

</div>

@endif

@endsection
