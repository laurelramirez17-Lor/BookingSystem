@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12 text-white">
    <div class="grid md:grid-cols-2 gap-8 rounded-lg border border-yellow-500/30 bg-black/70 p-6">
        <img class="w-full rounded-lg object-cover" style="aspect-ratio:16/10" src="{{ $room->image ? asset('storage/'.$room->image) : 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $room->name }}">
        <div><p class="text-yellow-300 uppercase tracking-widest text-sm">{{ $room->room_type ?? 'ARAUM accommodation' }}</p><h1 class="text-3xl font-bold text-yellow-300 mt-2">{{ $room->name }}</h1><p class="mt-5 text-gray-200 leading-7">{{ $room->description ?? 'Comfort, privacy, and ARAUM hospitality.' }}</p><p class="mt-3 text-gray-200">Maximum guests: {{ $room->max_guests ?? 2 }}</p><p class="mt-5 font-bold">PHP {{ number_format($room->price_min) }} – PHP {{ number_format($room->price_max) }} per night</p><div class="mt-6"><h2 class="font-semibold text-yellow-300">Included amenities</h2><p class="mt-2 text-gray-200">{{ $room->amenities ?? 'High-speed Wi-Fi · Breakfast service · Room service · Secure parking · Concierge assistance' }}</p></div><a class="inline-block mt-8 px-5 py-3 rounded-full bg-yellow-400 text-black font-bold" href="{{ route('customer.book.room', $room) }}">Book Now</a></div>
    </div>
</div>
@endsection
