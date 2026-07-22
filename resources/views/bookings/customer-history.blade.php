@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 text-white">
    <h1 class="text-2xl font-bold text-yellow-300">{{ $user->name }} — Booking History</h1>
    <p class="text-gray-300 mt-1">{{ $user->email }}</p>
    <div class="mt-6 space-y-3">
        @forelse($bookings as $booking)
            <article class="rounded-lg border border-yellow-400/30 bg-black/60 p-4 flex flex-wrap justify-between gap-3">
                <div><strong>{{ $booking->roomName() }}</strong><div class="text-gray-300">{{ $booking->booking_date }} to {{ $booking->checkout_date }} · {{ $booking->number_of_guests }} guests</div></div>
                <div class="text-yellow-300">{{ $booking->bookingStatusLabel() }} · {{ $booking->formattedTotalPrice() }}</div>
            </article>
        @empty
            <p class="text-gray-300">This customer has no linked bookings yet.</p>
        @endforelse
    </div>
</div>
@endsection
