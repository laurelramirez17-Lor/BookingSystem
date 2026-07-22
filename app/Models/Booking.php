<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'room_id',
        'user_id',
        'booking_reference',
        'customer_name',
        'email',
        'number_of_guests',
        'booking_date',
        'checkout_date',
        'booking_time',
        'total_price',
        'payment_status',
        'booking_status',
        'confirmation_file',
        'image',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'checkout_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking): void {
            if (! $booking->booking_reference) {
                do {
                    $reference = 'ARAUM-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
                } while (self::where('booking_reference', $reference)->exists());

                $booking->booking_reference = $reference;
            }
        });
    }

    /**
     * A booking belongs to one event/room.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Bookings which still reserve a room's dates. */
    public function scopeBlockingRoomDates(Builder $query, int $roomId, string $checkIn, string $checkOut): Builder
    {
        return $query->where('room_id', $roomId)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            // Hotel check-out is exclusive: a new guest may check in that day.
            ->whereDate('booking_date', '<', $checkOut)
            ->whereDate('checkout_date', '>', $checkIn);
    }

    public function roomName(): string
    {
        return $this->room->name ?? $this->event->name ?? 'ARAUM Room';
    }

    public function numberOfNights(): int
    {
        if (! $this->booking_date || ! $this->checkout_date) {
            return 1;
        }

        return max(1, (int) $this->booking_date->diffInDays($this->checkout_date));
    }

    public function formattedTotalPrice(): string
    {
        return $this->total_price !== null
            ? 'PHP '.number_format((float) $this->total_price, 2)
            : 'To be confirmed';
    }

    public function paymentStatusLabel(): string
    {
        return Str::of($this->payment_status ?: 'pending')
            ->replace('_', ' ')
            ->title()
            ->toString();
    }

    public function bookingStatusLabel(): string
    {
        return Str::of($this->booking_status ?: 'pending')->replace('_', ' ')->title()->toString();
    }

    public function uploadedFile(): ?string
    {
        return $this->confirmation_file ?: ($this->image ? 'uploads/'.$this->image : null);
    }

    public function uploadedFileName(): ?string
    {
        $file = $this->uploadedFile();

        return $file ? basename($file) : null;
    }

    public function uploadedFileIsImage(): bool
    {
        $file = $this->uploadedFile();

        if (! $file) {
            return false;
        }

        if (Storage::disk('public')->exists($file)) {
            return Str::startsWith((string) Storage::disk('public')->mimeType($file), 'image/');
        }

        $legacyPath = public_path($file);

        return is_file($legacyPath) && Str::startsWith((string) mime_content_type($legacyPath), 'image/');
    }
}
