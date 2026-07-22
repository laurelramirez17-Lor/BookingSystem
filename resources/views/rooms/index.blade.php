@extends('layouts.app')

@section('content')

<style>
    .rooms-page {
        min-height: 100vh;
        padding: 60px 28px;
    }

    .rooms-wrap {
        max-width: 1180px;
        margin: 0 auto;
    }

    .rooms-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
    }

    .rooms-title {
        color: #FFD700;
        font-size: 28px;
        font-weight: 900;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .rooms-subtitle {
        color: #ddd6bf;
        margin-top: 6px;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
        gap: 20px;
    }

    .room-card {
        background: rgba(10,10,10,.78);
        border: 1px solid rgba(255,215,0,.24);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(0,0,0,.45);
    }

    .room-img {
        width: 100%;
        aspect-ratio: 16 / 10;
        object-fit: cover;
        display: block;
    }

    .room-body {
        padding: 20px;
    }

    .room-name {
        color: #FFD700;
        font-size: 18px;
        font-weight: 800;
    }

    .room-desc,
    .room-price {
        color: #e7dcc3;
        margin-top: 8px;
        line-height: 1.6;
    }

    .room-price {
        font-weight: 800;
    }

    .room-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .gold-btn,
    .outline-btn,
    .danger-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 15px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-decoration: none;
    }

    .gold-btn {
        border: 0;
        background: linear-gradient(135deg,#FFD700,#B8860B);
        color: #111;
    }

    .outline-btn {
        border: 1px solid rgba(255,215,0,.35);
        color: #FFD700;
        background: transparent;
    }

    .danger-btn {
        border: 1px solid rgba(248,113,113,.45);
        color: #fecaca;
        background: transparent;
    }

    .alert {
        border: 1px solid rgba(255,215,0,.28);
        background: rgba(255,215,0,.08);
        color: #FFD700;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 18px;
    }
</style>

<div class="rooms-page">
    <div class="rooms-wrap">
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

        <div class="rooms-header">
            <div>
                <div class="rooms-title">ARAUM Rooms</div>
                <div class="rooms-subtitle">Room choices, amenities, and price ranges for your stay.</div>
            </div>

            @auth
                @if(in_array(auth()->user()->role, ['admin', 'front_desk', 'manager'], true))
                    <a href="{{ route('rooms.create') }}" class="gold-btn">Add Room</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('rooms.index') }}" class="room-card" style="padding:18px; margin-bottom:20px;">
            <div class="room-actions" style="align-items:end;">
                <label class="room-desc">Check-in<input type="date" name="check_in" min="{{ now()->toDateString() }}" value="{{ $filters['check_in'] ?? '' }}" class="block mt-1 text-black rounded px-2 py-1"></label>
                <label class="room-desc">Check-out<input type="date" name="check_out" value="{{ $filters['check_out'] ?? '' }}" class="block mt-1 text-black rounded px-2 py-1"></label>
                <label class="room-desc">Guests<input type="number" min="1" name="guests" value="{{ $filters['guests'] ?? 1 }}" class="block mt-1 text-black rounded px-2 py-1"></label>
                <button class="gold-btn" type="submit">Check Availability</button>
                <a class="outline-btn" href="{{ route('rooms.index') }}">Reset</a>
            </div>
        </form>

        <div class="rooms-grid">
            @forelse($rooms as $room)
                <article class="room-card">
                    <img
                        src="{{ $room->image ? asset('storage/'.$room->image) : ($roomFallbackImages[$room->name] ?? $roomFallbackImages['default']) }}"
                        alt="{{ $room->name }}"
                        class="room-img"
                    >

                    <div class="room-body">
                        <div class="room-name">{{ $room->name }}</div>
                        <div class="room-desc">{{ $room->room_type ?? 'Hotel Room' }} · Up to {{ $room->max_guests ?? 2 }} guests</div>
                        <div class="room-desc">{{ $room->description ?? 'Comfort, privacy, and ARAUM hospitality.' }}</div>
                        @if($room->amenities)<div class="room-desc"><strong>Amenities:</strong> {{ $room->amenities }}</div>@endif
                        <div class="room-price">PHP {{ number_format($room->price_min) }} - PHP {{ number_format($room->price_max) }}</div>

                        <div class="room-actions">
                            <a href="{{ route('rooms.show', $room) }}" class="outline-btn">View Details</a>
                            <a href="{{ route('customer.book.room', $room) }}" class="gold-btn">Book This Room</a>

                            @auth
                                @if(in_array(auth()->user()->role, ['admin', 'front_desk', 'manager'], true))
                                    <a href="{{ route('rooms.edit', $room) }}" class="outline-btn">Edit</a>

                                    <form action="{{ route('rooms.destroy', $room) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="danger-btn" type="submit">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </article>
            @empty
                <div class="room-card">
                    <div class="room-body">
                        <div class="room-name">No rooms yet</div>
                        <div class="room-desc">Rooms will appear here once they are added by the hotel team.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
