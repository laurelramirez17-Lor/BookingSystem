<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class RoomController extends Controller
{
    public function index()
    {
        $filters = request()->validate([
            'check_in' => 'nullable|date|after_or_equal:today',
            'check_out' => 'nullable|required_with:check_in|date|after:check_in',
            'guests' => 'nullable|integer|min:1',
        ]);

        $rooms = Room::query()
            ->when(($filters['check_in'] ?? null) && ($filters['check_out'] ?? null), fn ($query) => $query->availableBetween($filters['check_in'], $filters['check_out']))
            ->when($filters['guests'] ?? null, fn ($query, $guests) => $query->where('max_guests', '>=', $guests))
            ->get();

        return view('rooms.index', compact('rooms', 'filters'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|string|max:255',
            'description' => 'required|string',
            'amenities' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1|max:100',
            'availability_status' => 'required|in:available,unavailable,maintenance',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        // Existing database uses a min/max price range. For room reservations,
        // one nightly price is stored in both fields.
        $data['price_min'] = (int) $data['price'];
        $data['price_max'] = (int) $data['price'];
        unset($data['price']);

        // Keep room creation working on installations that have not yet run the
        // optional availability-status migration.
        if (! Schema::hasColumn('rooms', 'availability_status')) {
            unset($data['availability_status']);
        }

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|string|max:255',
            'description' => 'required|string',
            'amenities' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1|max:100',
            'availability_status' => 'required|in:available,unavailable,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }

            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $data['price_min'] = (int) $data['price'];
        $data['price_max'] = (int) $data['price'];
        unset($data['price']);

        if (! Schema::hasColumn('rooms', 'availability_status')) {
            unset($data['availability_status']);
        }

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
