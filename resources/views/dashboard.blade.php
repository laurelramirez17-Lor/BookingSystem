<x-app-layout>
    @if($mode === 'admin')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-300 tracking-widest uppercase leading-tight">
            {{ $mode === 'admin' ? 'Hotel Operations' : 'Guest Dashboard' }}
        </h2>
    </x-slot>

    <style>
        .dash-page {
            padding: 42px 24px 70px;
        }

        .dash-wrap {
            max-width: 1180px;
            margin: 0 auto;
        }

        .dash-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(280px, .85fr);
            gap: 22px;
            align-items: stretch;
            margin-bottom: 24px;
        }

        .dash-panel {
            background: rgba(10,10,10,.78);
            border: 1px solid rgba(255,215,0,.24);
            border-radius: 8px;
            box-shadow: 0 26px 70px rgba(0,0,0,.45);
            padding: 24px;
        }

        .dash-title {
            color: #FFD700;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 0 0 10px;
        }

        .dash-copy {
            color: #ddd6bf;
            line-height: 1.7;
            margin: 0;
        }

        .stat-grid,
        .content-grid,
        .room-grid {
            display: grid;
            gap: 16px;
        }

        .stat-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-bottom: 24px;
        }

        .content-grid {
            grid-template-columns: minmax(0, 1.25fr) minmax(320px, .75fr);
        }

        .room-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            margin-top: 16px;
        }

        .stat-card,
        .mini-card,
        .room-card {
            background: rgba(0,0,0,.62);
            border: 1px solid rgba(255,215,0,.18);
            border-radius: 8px;
            padding: 18px;
        }

        .stat-label,
        .section-label {
            color: #FFD700;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .stat-value {
            color: #fff;
            font-size: 34px;
            font-weight: 900;
            margin-top: 8px;
        }

        .action-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .gold-btn,
        .outline-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .gold-btn {
            background: linear-gradient(135deg,#FFD700,#B8860B);
            color: #111;
        }

        .outline-btn {
            border: 1px solid rgba(255,215,0,.35);
            color: #FFD700;
        }

        .section-title {
            color: #fff;
            font-size: 18px;
            font-weight: 800;
            margin: 6px 0 16px;
        }

        .list-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .list-row:last-child {
            border-bottom: 0;
        }

        .primary-text {
            color: #fff;
            font-weight: 700;
        }

        .muted-text {
            color: #bdb6a3;
            font-size: 13px;
            margin-top: 3px;
        }

        .room-img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid rgba(255,215,0,.18);
            margin-bottom: 14px;
        }

        .amenity-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 16px;
        }

        .amenity {
            border: 1px solid rgba(255,215,0,.18);
            border-radius: 999px;
            color: #f3ead0;
            padding: 10px 14px;
            font-size: 13px;
        }

        .customer-search { width: 100%; background: rgba(255,255,255,.06); border: 1px solid rgba(255,215,0,.25); border-radius: 8px; color: #fff; padding: 11px 13px; }

        /* FullCalendar: the operational view keeps its existing data/actions, with a calmer hotel UI. */
        #adminBookingCalendar { background:#fcfaf5 !important; border:1px solid #e8dcc8 !important; border-radius:16px !important; padding:20px !important; box-shadow:inset 0 1px #fff,0 12px 32px rgba(0,0,0,.12); }
        #adminBookingCalendar .fc { font-family:inherit; color:#26352f; }
        #adminBookingCalendar .fc-toolbar { gap:12px; flex-wrap:wrap; }
        #adminBookingCalendar .fc-toolbar-title { font-family:Georgia,serif; font-size:24px; color:#26352f; }
        #adminBookingCalendar .fc-button { background:#26352f; border:0; border-radius:999px; box-shadow:none; font-size:12px; font-weight:800; padding:9px 14px; text-transform:capitalize; }
        #adminBookingCalendar .fc-button:hover,#adminBookingCalendar .fc-button-active { background:#b8863e !important; }
        #adminBookingCalendar .fc-theme-standard td,#adminBookingCalendar .fc-theme-standard th { border-color:#eee5d7; }
        #adminBookingCalendar .fc-col-header-cell { background:#f4eee4; padding:8px 0; color:#786448; font-size:11px; letter-spacing:1px; text-transform:uppercase; }
        #adminBookingCalendar .fc-daygrid-day { transition:background .2s; } #adminBookingCalendar .fc-daygrid-day:hover { background:#fbf4e8; }
        #adminBookingCalendar .fc-daygrid-day-number { color:#34433b; padding:9px; font-weight:700; }
        #adminBookingCalendar .fc-day-today { background:#f5ead5 !important; } #adminBookingCalendar .fc-event { border:0; border-radius:6px; background:#b8863e; padding:3px 5px; font-weight:700; }

        @media (max-width: 900px) {
            .dash-hero,
            .content-grid,
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .amenity-list {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dash-page">
        <div class="dash-wrap">
            @php
                $roomFallbackImages = [
                    'Deluxe King Room' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80',
                    'Premier Twin Room' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=900&q=80',
                    'Executive Suite' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=900&q=80',
                    'Family Residence' => 'https://images.unsplash.com/photo-1560448075-bb485b067938?auto=format&fit=crop&w=900&q=80',
                    'Presidential Suite' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=900&q=80',
                    'default' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=900&q=80',
                ];
            @endphp

            @if($mode === 'admin')
                <div class="dash-hero">
                    <section class="dash-panel">
                        <p class="section-label">Admin Side</p>
                        <h1 class="dash-title">ARAUM Control Center</h1>
                        <p class="dash-copy">Manage reservations, guest records, room inventory, pricing, and uploaded payment proofs from one hotel operations dashboard.</p>

                        <div class="action-row">
                            <a href="{{ route('bookings.create') }}" class="gold-btn">Add Reservation</a>
                            <a href="{{ route('rooms.create') }}" class="outline-btn">Add Room</a>
                        </div>
                    </section>

                    <section class="dash-panel">
                        <p class="section-label">Quick Management</p>
                        <div class="action-row">
                            <a href="{{ route('bookings.index') }}" class="gold-btn">Reservations</a>
                            <a href="{{ route('rooms.index') }}" class="outline-btn">Rooms</a>
                        </div>
                    </section>
                </div>

                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-label">Rooms</div>
                        <div class="stat-value">{{ $totalRooms }}</div>
                    </div>
                    <div class="stat-card"><div class="stat-label">Total Users</div><div class="stat-value">{{ $totalUsers }}</div></div>
                    <div class="stat-card"><div class="stat-label">Pending</div><div class="stat-value">{{ $pendingBookings }}</div></div>
                    <div class="stat-card"><div class="stat-label">Approved Reservations</div><div class="stat-value">{{ $confirmedBookings }}</div></div>
                    <div class="stat-card"><div class="stat-label">Cancelled</div><div class="stat-value">{{ $cancelledBookings }}</div></div>
                    <div class="stat-card"><div class="stat-label">Available Rooms</div><div class="stat-value">{{ $availableRooms }}</div></div>
                    <div class="stat-card"><div class="stat-label">Occupied Rooms</div><div class="stat-value">{{ $occupiedRooms }}</div></div>
                    <div class="stat-card"><div class="stat-label">Confirmed Revenue</div><div class="stat-value">PHP {{ number_format($totalRevenue, 2) }}</div></div>
                </div>

                <div class="content-grid">
                    <section class="dash-panel">
                        <p class="section-label">Latest Reservations</p>
                        <h3 class="section-title">Reservation Details</h3>

                        @forelse($latestBookings as $booking)
                            <div class="list-row">
                                <div>
                                    <div class="primary-text">{{ $booking->customer_name }}</div>
                                    <div class="muted-text">{{ $booking->room?->name ?? 'No room assigned' }} | {{ $booking->booking_date }} to {{ $booking->checkout_date ?? 'N/A' }}</div>
                                    <div class="muted-text">Status: {{ $booking->bookingStatusLabel() }}</div>
                                </div>
                                <div class="action-row">
                                    <a href="{{ route('bookings.show', $booking) }}" class="outline-btn">View</a>
                                    <a href="{{ route('bookings.edit', $booking) }}" class="outline-btn">Edit</a>
                                    @if($booking->booking_status === 'pending')
                                        <form action="{{ route('bookings.status', $booking) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="booking_status" value="confirmed"><button class="gold-btn" type="submit">Approve</button></form>
                                        <form action="{{ route('bookings.status', $booking) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="booking_status" value="rejected"><button class="outline-btn" type="submit">Reject</button></form>
                                    @endif
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Delete this reservation from the database?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="outline-btn">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="dash-copy">No reservations yet.</p>
                        @endforelse
                    </section>

                    <section class="dash-panel">
                        <p class="section-label">Customer Details</p>
                        <h3 class="section-title">Recent Customers</h3>

                        <label class="section-label" for="customerSearch">Fast customer search</label>
                        <div class="action-row" style="margin:8px 0 12px; flex-wrap:nowrap;">
                            <input id="customerSearch" class="customer-search" placeholder="Name, email, or booking ID" autocomplete="off">
                            <button type="button" class="gold-btn" onclick="document.getElementById('customerSearch').dispatchEvent(new Event('input'))">Search</button>
                        </div>
                        <div id="customerSearchResults" aria-live="polite"></div>

                        @forelse($latestCustomers as $customer)
                            <div class="list-row">
                                <div>
                                    <div class="primary-text">{{ $customer->name }}</div>
                                    <div class="muted-text">{{ $customer->email }}</div>
                                    <a href="{{ route('customers.bookings', $customer) }}" class="outline-btn" style="margin-top:8px;">History</a>
                                </div>
                            </div>
                        @empty
                            <p class="dash-copy">No customers yet.</p>
                        @endforelse
                    </section>
                </div>

                <section class="dash-panel" style="margin-top:16px;">
                    <p class="section-label">Live Booking Calendar</p>
                    <h3 class="section-title">Reserved Dates</h3>
                    <div id="adminBookingCalendar"></div>
                </section>

                <section class="dash-panel" style="margin-top:16px;">
                    <p class="section-label">Room Inventory</p>
                    <h3 class="section-title">Rooms and Price Ranges</h3>

                    <div class="room-grid">
                        @forelse($rooms as $room)
                            <article class="room-card">
                                <div class="primary-text">{{ $room->name }}</div>
                                <div class="muted-text">{{ $room->description ?? 'No description yet.' }}</div>
                                <div class="muted-text">PHP {{ number_format($room->price_min) }} - PHP {{ number_format($room->price_max) }}</div>
                                <div class="action-row">
                                    <a href="{{ route('rooms.edit', $room) }}" class="outline-btn">Edit</a>
                                </div>
                            </article>
                        @empty
                            <p class="dash-copy">No rooms have been added yet.</p>
                        @endforelse
                    </div>
                </section>
            @else
                <div class="dash-hero">
                    <section class="dash-panel">
                        <p class="section-label">Customer Side</p>
                        <h1 class="dash-title">Plan Your ARAUM Stay</h1>
                        <p class="dash-copy">Browse rooms, review amenities, and reserve your suite without leaving the guest dashboard.</p>

                        <div class="action-row">
                            <a href="{{ route('rooms.index') }}" class="gold-btn">Browse Rooms</a>
                            <a href="{{ route('customer.book.create') }}" class="outline-btn">Book Now</a>
                        </div>
                    </section>

                    <section class="dash-panel">
                        <p class="section-label">Amenities</p>
                        <div class="amenity-list">
                            @foreach($amenities as $amenity)
                                <div class="amenity">{{ $amenity }}</div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <section class="dash-panel">
                    <p class="section-label">Available Rooms</p>
                    <h3 class="section-title">Rooms and Amenities</h3>

                    <div class="room-grid">
                        @forelse($rooms as $room)
                            <article class="room-card">
                                <img
                                    src="{{ $room->image ? asset('storage/'.$room->image) : ($roomFallbackImages[$room->name] ?? $roomFallbackImages['default']) }}"
                                    alt="{{ $room->name }}"
                                    class="room-img"
                                >
                                <div class="primary-text">{{ $room->name }}</div>
                                <div class="muted-text">{{ $room->description ?? 'Elegant comfort with ARAUM service.' }}</div>
                                <div class="muted-text">PHP {{ number_format($room->price_min) }} - PHP {{ number_format($room->price_max) }}</div>
                                <div class="action-row">
                                    <a href="{{ route('customer.book.room', $room) }}" class="gold-btn">Book Room</a>
                                </div>
                            </article>
                        @empty
                            <p class="dash-copy">Rooms will appear here once the hotel team adds them.</p>
                        @endforelse
                    </div>
                </section>

                <section class="dash-panel" style="margin-top:16px;">
                    <p class="section-label">My Reservations</p>
                    <h3 class="section-title">Booking History</h3>

                    @forelse($myBookings as $booking)
                        <div class="list-row">
                            <div>
                                <div class="primary-text">{{ $booking->room?->name ?? 'Reserved stay' }}</div>
                                <div class="muted-text">{{ $booking->booking_date }} to {{ $booking->checkout_date ?? 'N/A' }} | {{ $booking->email }}</div>
                            </div>
                            <a href="{{ route('customer.book.summary', $booking) }}" class="outline-btn">Summary</a>
                        </div>
                    @empty
                        <p class="dash-copy">You do not have reservations connected to this email yet.</p>
                    @endforelse
                </section>
            @endif
        </div>
    </div>
    @if($mode === 'admin')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const target = document.getElementById('adminBookingCalendar');
                if (target) {
                    new FullCalendar.Calendar(target, {
                        initialView: 'dayGridMonth', height: 'auto',
                        events: '{{ route('booking.availability') }}',
                    }).render();
                }
                const search = document.getElementById('customerSearch');
                const results = document.getElementById('customerSearchResults');
                let timer;
                search?.addEventListener('input', () => {
                    clearTimeout(timer);
                    timer = setTimeout(async () => {
                        if (search.value.trim().length < 2) { results.innerHTML = ''; return; }
                        const response = await fetch(`{{ route('admin.customers.search') }}?q=${encodeURIComponent(search.value)}`, { headers: { Accept: 'application/json' } });
                        const customers = await response.json();
                        results.innerHTML = customers.length ? customers.map(customer => `<div class="mini-card" style="margin:8px 0"><div class="primary-text">${customer.name}</div><div class="muted-text">${customer.email}</div>${customer.bookings.map(booking => `<div class="muted-text">${booking.reference} · ${booking.room} · ${booking.dates} · ${booking.status}</div>`).join('')}</div>`).join('') : '<p class="muted-text">No matching customers.</p>';
                    }, 250);
                });
            });
        </script>
    @endif
</x-app-layout>
