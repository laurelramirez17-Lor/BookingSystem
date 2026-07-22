<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['rooms' => Room::orderBy('name')->get()]);
})->name('welcome');

Route::get('/booking/verify/{bookingReference}', [CustomerBookingController::class, 'verify'])->name('booking.verify');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/availability', [CustomerBookingController::class, 'availability'])->name('booking.availability');

Route::get('/dashboard', DashboardController::class)->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/book', [CustomerBookingController::class, 'create'])->name('customer.book.create');
    Route::post('/book', [CustomerBookingController::class, 'store'])->name('customer.book.store');
    Route::get('/book/{booking}/summary', [CustomerBookingController::class, 'summary'])->name('customer.book.summary');
    Route::get('/bookings/{booking}/proof', [CustomerBookingController::class, 'proof'])->name('bookings.proof.view');
    Route::get('/bookings/{booking}/proof/download', [CustomerBookingController::class, 'downloadProof'])->name('bookings.proof.download');
    Route::get('/rooms/{room}/book', [CustomerBookingController::class, 'createForRoom'])->name('customer.book.room');

    Route::middleware('role:admin,front_desk,manager')->group(function () {
        Route::get('admin/customers/search', [DashboardController::class, 'customerSearch'])->name('admin.customers.search');
        Route::resource('events', EventController::class);
        Route::resource('bookings', BookingController::class);
        Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
        Route::get('customers/{user}/bookings', [BookingController::class, 'customerHistory'])->name('customers.bookings');
        Route::resource('rooms', RoomController::class)->except(['index', 'show']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Keep this generic route after the resource routes. Otherwise "/rooms/create"
// is treated as a room ID and returns a 404 before the create route can match.
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

require __DIR__.'/auth.php';
