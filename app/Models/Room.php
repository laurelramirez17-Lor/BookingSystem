<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Room extends Model
{
    protected $fillable = [
        'name',
        'room_type',
        'description',
        'amenities',
        'price_min',
        'price_max',
        'max_guests',
        'image',
        'availability_status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeAvailableBetween(Builder $query, string $checkIn, string $checkOut): Builder
    {
        return $query->whereDoesntHave('bookings', function (Builder $bookingQuery) use ($checkIn, $checkOut) {
            $bookingQuery->whereIn('booking_status', ['pending', 'confirmed'])
                ->whereDate('booking_date', '<', $checkOut)
                ->whereDate('checkout_date', '>', $checkIn);
        });
    }
}
