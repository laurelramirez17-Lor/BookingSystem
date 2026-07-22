@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">

<style>

/* FULL PAGE LUXURY BACKGROUND */
.booking-page{
    min-height:100vh;
    display:flex;
}

/* LEFT SIDE (IMAGE / BRAND AREA) */
.left-panel{
    flex:1;
    background:
        linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.75)),
        url("https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2000&q=80");
    background-size:cover;
    background-position:center;
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:80px;
    color:#FFD700;
}

.brand-title{
    font-family:'Cinzel',serif;
    font-size:70px;
    letter-spacing:10px;
    margin-bottom:20px;
    text-shadow:0 0 25px rgba(255,215,0,.25);
}

.brand-text{
    font-size:18px;
    color:#e6e6e6;
    max-width:400px;
    line-height:1.7;
}

/* RIGHT SIDE (FORM AREA) */
.right-panel{
    flex:1;
    background:#111;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 30px;
}

.form-area{
    width:100%;
    max-width:560px;
    background:#fff;
    color:#1f2937;
    border:1px solid rgba(255,215,0,.35);
    border-radius:8px;
    padding:34px;
    box-shadow:0 24px 60px rgba(0,0,0,.35);
}

.form-title{
    font-family:'Cinzel',serif;
    color:#8a6500;
    font-size:32px;
    letter-spacing:4px;
    margin-bottom:10px;
}

.form-subtitle{
    color:#4b5563;
    margin-bottom:30px;
    font-size:14px;
}

.form-label{
    display:block;
    color:#374151;
    font-weight:700;
    margin:18px 0 8px;
}

.form-control,
.form-select{
    width:100%;
    background:#fff;
    border:1px solid #cbd5e1;
    border-radius:6px;
    color:#111827;
    padding:12px 14px;
}

.form-control:focus,
.form-select:focus{
    outline:none;
    box-shadow:0 0 0 3px rgba(184,134,11,.18);
    border-color:#B8860B;
    background:#fff;
    color:#111827;
}

.form-select option{
    background:#fff;
    color:#111827;
}

.payment-preview{
    border:1px solid rgba(184,134,11,.28);
    border-radius:8px;
    padding:16px;
    margin-top:22px;
    background:#fffaf0;
}

.payment-preview-title{
    color:#8a6500;
    font-weight:800;
    letter-spacing:.5px;
    margin-bottom:10px;
}

.payment-line{
    display:flex;
    justify-content:space-between;
    gap:16px;
    color:#374151;
    font-size:14px;
    margin-top:8px;
}

.payment-total{
    border-top:1px solid rgba(184,134,11,.22);
    margin-top:12px;
    padding-top:12px;
    font-size:18px;
    font-weight:800;
    color:#111827;
}

.payment-note{
    color:#6b7280;
    font-size:13px;
    line-height:1.5;
    margin-top:10px;
}

.date-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

#bookingCalendar { margin-top: 12px; padding: 16px; border: 1px solid #eadfcd; border-radius: 14px; background: #fffcf7; box-shadow: inset 0 1px #fff; }
.date-selection { margin-top: 10px; color: #665d50; font-size: 13px; background:#fff8eb; border-radius:8px; padding:10px 12px; }
#bookingCalendar .fc { font-family:'Poppins',sans-serif; color:#34433b; } #bookingCalendar .fc-toolbar { gap:8px; flex-wrap:wrap; } #bookingCalendar .fc-toolbar-title { font-family:'Cinzel',serif; font-size:18px; color:#6e5116; }
#bookingCalendar .fc-button { background:#26352f; border:0; border-radius:999px; box-shadow:none; font-size:11px; font-weight:700; padding:8px 11px; text-transform:capitalize; } #bookingCalendar .fc-button:hover,#bookingCalendar .fc-button-active { background:#b8860b!important; }
#bookingCalendar .fc-theme-standard td,#bookingCalendar .fc-theme-standard th { border-color:#eee3d2; } #bookingCalendar .fc-col-header-cell { color:#856d48; background:#f8f0e3; font-size:10px; letter-spacing:.7px; text-transform:uppercase; padding:6px 0; }
#bookingCalendar .fc-daygrid-day { transition:background .2s; } #bookingCalendar .fc-daygrid-day:hover { background:#fdf4e6; } #bookingCalendar .fc-daygrid-day-number { color:#34433b; font-size:12px; font-weight:700; padding:8px; }
#bookingCalendar .fc-day-today { background:#fff0cd!important; } #bookingCalendar .fc-highlight { background:#ead29a99; } #bookingCalendar .fc-event { border:0; border-radius:5px; background:#a85a4b; padding:2px 4px; font-size:10px; }

/* BUTTON */
.btn-luxury{
    margin-top:30px;
    width:100%;
    padding:14px;
    border:none;
    background:linear-gradient(135deg,#FFD700,#B8860B);
    color:#111;
    font-weight:700;
    letter-spacing:2px;
    border-radius:50px;
    transition:.3s;
}

.btn-luxury:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(255,215,0,.25);
}

/* MOBILE */
@media(max-width:900px){
    .booking-page{
        flex-direction:column;
    }

    .left-panel{
        padding:60px 30px;
        text-align:center;
        align-items:center;
    }

    .brand-text{
        max-width:100%;
    }

    .form-area{
        padding:26px;
    }
}

@media(max-width:640px){
    .date-grid{
        grid-template-columns:1fr;
        gap:0;
    }

    .brand-title{
        font-size:46px;
        letter-spacing:7px;
    }
}

</style>

<div class="booking-page">

    <!-- LEFT SIDE -->
    <div class="left-panel">

        <h1 class="brand-title">ARAUM</h1>

        <p class="brand-text">
            Where timeless elegance meets modern luxury.
            Experience world-class comfort, refined service,
            and unforgettable stays crafted just for you.
        </p>

    </div>

    <!-- RIGHT SIDE -->
    <div class="right-panel">

        <div class="form-area">

            <h2 class="form-title">Reservation</h2>
            <p class="form-subtitle">
                Complete your details to secure your luxury stay
                @isset($selectedRoom)
                    in {{ $selectedRoom->name }}
                @endisset
            </p>

            @isset($selectedRoom)
                <div style="border:1px solid rgba(184,134,11,.25); border-radius:8px; padding:14px; margin-bottom:18px; background:#fffaf0;">
                    <strong style="color:#8a6500;">Selected Room:</strong>
                    <span>{{ $selectedRoom->name }} - PHP {{ number_format($selectedRoom->price_min) }} to PHP {{ number_format($selectedRoom->price_max) }}</span>
                    @if($selectedRoom->description)
                        <div style="font-size:13px; color:#4b5563; margin-top:6px;">{{ $selectedRoom->description }}</div>
                    @endif
                </div>
            @endisset

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

                @isset($selectedRoom)
                    <input type="hidden" name="room_id" value="{{ $selectedRoom->id }}">
                @endisset

                @isset($selectedRoom)
                    <label class="form-label">Selected Room</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $selectedRoom->name }}"
                        readonly>
                @else
                    <label class="form-label">Room</label>
                    <select name="room_id" class="form-select" id="roomSelector" required>
                        <option value="">Choose a room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>{{ $room->name }} — PHP {{ number_format($room->price_min) }}/night</option>
                        @endforeach
                    </select>
                @endisset

                <label class="form-label">Full Name</label>
                <input type="text" name="customer_name" class="form-control" value="{{ auth()->user()->name }}" readonly required>

                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" readonly required>

                <label class="form-label">Number of Guests</label>
                <input type="number" name="number_of_guests" class="form-control" value="{{ old('number_of_guests', 1) }}" min="1" max="20" required>

                <label class="form-label">Select your stay dates</label>
                <p class="form-subtitle" style="margin-bottom:8px">Choose your dates below or on the calendar. Red dates are unavailable.</p>
                <div class="date-grid">
                    <div>
                        <label class="form-label" for="bookingDate">Check-in</label>
                        <input id="bookingDate" type="date" name="booking_date" class="form-control" min="{{ now()->toDateString() }}" value="{{ old('booking_date') }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="checkoutDate">Check-out</label>
                        <input id="checkoutDate" type="date" name="checkout_date" class="form-control" min="{{ now()->addDay()->toDateString() }}" value="{{ old('checkout_date') }}" required>
                    </div>
                </div>
                <div id="bookingCalendar"></div>
                <div class="date-selection" id="dateSelection">Select a room, then choose your check-in and check-out dates.</div>

                @isset($selectedRoom)
                    <div
                        class="payment-preview"
                        id="paymentPreview"
                        data-nightly-rate="{{ $selectedRoom->price_min }}"
                    >
                        <div class="payment-preview-title">Payment Amount</div>
                        <div class="payment-line">
                            <span>{{ $selectedRoom->name }}</span>
                            <strong>PHP {{ number_format($selectedRoom->price_min, 2) }} / night</strong>
                        </div>
                        <div class="payment-line">
                            <span>Nights</span>
                            <strong id="paymentNights">1</strong>
                        </div>
                        <div class="payment-line payment-total">
                            <span>Total to Pay</span>
                            <span id="paymentTotal">PHP {{ number_format($selectedRoom->price_min, 2) }}</span>
                        </div>
                        <div class="payment-note">
                            Upload your receipt after paying this amount. The final saved total will use the selected room rate and your check-in/check-out dates.
                        </div>
                    </div>
                @else
                    <div class="payment-preview">
                        <div class="payment-preview-title">Payment Amount</div>
                        <div class="payment-note">
                            Select a room from the Rooms page first so the payment amount can be calculated before you upload a receipt.
                        </div>
                    </div>
                @endisset

                <label class="form-label">Upload Proof</label>
                <input type="file" name="confirmation_file" class="form-control" accept="image/*,.pdf">

                <label class="form-label">Special Requests</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>

                <button type="submit" class="btn-luxury">
                    CONFIRM RESERVATION
                </button>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const preview = document.getElementById('paymentPreview');
    const checkIn = document.querySelector('[name="booking_date"]');
    const checkOut = document.querySelector('[name="checkout_date"]');
    const roomSelector = document.getElementById('roomSelector');
    const calendarElement = document.getElementById('bookingCalendar');
    const dateSelection = document.getElementById('dateSelection');
    const nightsLabel = document.getElementById('paymentNights');
    const totalLabel = document.getElementById('paymentTotal');
    const nightlyRate = preview ? Number(preview.dataset.nightlyRate || 0) : 0;
    const formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
    });

    const formatSelection = () => {
        if (checkIn.value && checkOut.value) {
            dateSelection.textContent = `Check-in: ${checkIn.value} · Check-out: ${checkOut.value}`;
        } else if (checkIn.value) {
            dateSelection.textContent = `Check-in: ${checkIn.value}. Now choose a later check-out date.`;
        } else {
            dateSelection.textContent = 'Select a room, then choose your check-in and check-out dates.';
        }
    };

    const syncDateLimits = () => {
        if (! checkIn.value) {
            return;
        }

        const minimumCheckout = new Date(`${checkIn.value}T00:00:00`);
        minimumCheckout.setDate(minimumCheckout.getDate() + 1);
        checkOut.min = [
            minimumCheckout.getFullYear(),
            String(minimumCheckout.getMonth() + 1).padStart(2, '0'),
            String(minimumCheckout.getDate()).padStart(2, '0'),
        ].join('-');

        if (checkOut.value && checkOut.value <= checkIn.value) {
            checkOut.value = '';
        }
    };

    const updatePayment = () => {
        syncDateLimits();
        formatSelection();

        if (! preview || ! nightsLabel || ! totalLabel) {
            return;
        }

        const start = checkIn.value ? new Date(`${checkIn.value}T00:00:00`) : null;
        const end = checkOut.value ? new Date(`${checkOut.value}T00:00:00`) : null;
        let nights = 1;

        if (start && end && end >= start) {
            nights = Math.max(1, Math.round((end - start) / 86400000));
        }

        nightsLabel.textContent = nights;
        totalLabel.textContent = formatter.format(nightlyRate * nights);
    };

    const selectedRoomId = () => roomSelector?.value || '{{ $selectedRoom->id ?? '' }}';
    const rangeIsAvailable = (start, end) => !calendar.getEvents().some(event =>
        event.display === 'background' && start < event.end && end > event.start
    );

    const calendar = new FullCalendar.Calendar(calendarElement, {
        initialView: 'dayGridMonth', height: 'auto', selectable: true, selectMirror: true,
        validRange: { start: '{{ now()->toDateString() }}' },
        events: { url: '{{ route('booking.availability') }}', extraParams: () => ({ room_id: selectedRoomId() }) },
        selectAllow: selection => Boolean(selectedRoomId()) && rangeIsAvailable(selection.start, selection.end),
        select: info => {
            if (info.end <= info.start) return;
            checkIn.value = info.startStr;
            checkOut.value = info.endStr;
            dateSelection.textContent = `Check-in: ${info.startStr} · Check-out: ${info.endStr}`;
            updatePayment();
        },
        dateClick: info => {
            if (! selectedRoomId()) {
                dateSelection.textContent = 'Please select a room before choosing dates.';
                return;
            }

            const clickedDate = info.dateStr;
            const clickedEnd = new Date(`${clickedDate}T00:00:00`);
            clickedEnd.setDate(clickedEnd.getDate() + 1);

            if (! checkIn.value || checkOut.value || clickedDate <= checkIn.value) {
                if (! rangeIsAvailable(info.date, clickedEnd)) return;
                checkIn.value = clickedDate;
                checkOut.value = '';
            } else if (rangeIsAvailable(new Date(`${checkIn.value}T00:00:00`), info.date)) {
                checkOut.value = clickedDate;
            }

            updatePayment();
        },
    });
    calendar.render();
    checkIn.addEventListener('change', updatePayment);
    checkOut.addEventListener('change', updatePayment);
    roomSelector?.addEventListener('change', () => { checkIn.value = ''; checkOut.value = ''; dateSelection.textContent = 'Select a date range to continue.'; calendar.refetchEvents(); updatePayment(); });
    updatePayment();
});
</script>

@endsection
