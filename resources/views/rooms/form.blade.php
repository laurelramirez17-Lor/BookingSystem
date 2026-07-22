<style>
    .room-form-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
    }

    .room-form-card {
        width: 100%;
        max-width: 720px;
        background: rgba(10,10,10,.78);
        border: 1px solid rgba(255,215,0,.25);
        border-radius: 8px;
        box-shadow: 0 30px 80px rgba(0,0,0,.75);
        overflow: hidden;
    }

    .room-form-header {
        padding: 24px;
        background: linear-gradient(90deg,#FFD700,#B8860B);
        color: #111;
        font-weight: 900;
        letter-spacing: 3px;
        text-transform: uppercase;
        text-align: center;
    }

    .room-form-body {
        padding: 34px;
    }

    .form-label {
        display: block;
        color: #FFD700;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 18px 0 8px;
    }

    .form-control {
        width: 100%;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,215,0,.25);
        border-radius: 8px;
        color: #fff;
        padding: 12px 14px;
    }

    .form-control:focus {
        outline: 0;
        border-color: #FFD700;
        box-shadow: 0 0 0 3px rgba(255,215,0,.14);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .error-box {
        background: rgba(248,113,113,.12);
        border: 1px solid rgba(248,113,113,.35);
        color: #fecaca;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 18px;
    }

    .preview-img {
        width: 180px;
        max-width: 100%;
        border-radius: 8px;
        border: 1px solid rgba(255,215,0,.28);
        margin-top: 12px;
    }

    .btn-room {
        width: 100%;
        margin-top: 26px;
        min-height: 48px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg,#FFD700,#B8860B);
        color: #111;
        font-weight: 900;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<div class="room-form-page">
    <div class="room-form-card">
        <div class="room-form-header">ARAUM - {{ $title }}</div>

        <div class="room-form-body">
            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif

                <label class="form-label">Room Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}" required>

                <label class="form-label">Room Type</label>
                <input type="text" name="room_type" class="form-control" value="{{ old('room_type', $room->room_type) }}" placeholder="e.g. Deluxe King">

                <label class="form-label">Amenities / Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $room->description) }}</textarea>

                <label class="form-label">Amenities</label>
                <textarea name="amenities" class="form-control" rows="3" placeholder="Wi-Fi, breakfast, air conditioning">{{ old('amenities', $room->amenities) }}</textarea>

                <label class="form-label">Price Per Night (PHP)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $room->price_min) }}" min="0" step="0.01" required>

                <label class="form-label">Maximum Guests</label>
                <input type="number" name="max_guests" class="form-control" value="{{ old('max_guests', $room->max_guests ?? 2) }}" min="1" max="100" required>

                <label class="form-label">Availability Status</label>
                <select name="availability_status" class="form-control" required>
                    @foreach(['available' => 'Available', 'unavailable' => 'Unavailable', 'maintenance' => 'Maintenance'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('availability_status', $room->availability_status ?? 'available') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <label class="form-label">Room Image</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp" @if(!$room->exists) required @endif>

                @if($room->image)
                    <img src="{{ asset('storage/'.$room->image) }}" class="preview-img" alt="{{ $room->name }}">
                @endif

                <button type="submit" class="btn-room">Save Room</button>
            </form>
        </div>
    </div>
</div>
