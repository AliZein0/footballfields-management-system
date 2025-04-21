<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\FieldController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController; // Ensure this controller exists in the specified namespace

Route::get('/players', [PlayerController::class, 'index'])->name('players.index');


Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');

Route::get('/show', [PlayerController::class, 'show'])->name('players.profile');



// Add this to your routes/web.php or routes/api.php file
Route::get('/fields/search', [FieldController::class, 'search'])->name('fields.search');

Route::get('/booking/{player}/{field}', [BookingController::class, 'show'])->name('booking.show');

Route::get('/api/fields/{fieldId}/booked-slots', [BookingController::class, 'getBookedSlots']);
Route::post('/bookings', [BookingController::class, 'store']);



Route::get('/fields/{field}/available-slots', [BookingController::class, 'checkAvailability']);
