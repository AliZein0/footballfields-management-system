<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SportFieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\StoreUserSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

// Public Routes (no authentication required)
Route::get('/fields/search', [SportFieldController::class, 'search'])->name('fields.search');
// Add this at the top of your routes file

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Protected routes (require authentication)
Route::middleware(['auth', StoreUserSession::class])->group(function () {
    // Home route
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Player routes
    Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/profile/{player}', [PlayerController::class, 'profile'])->name('players.profile');
    Route::get('/player/{id}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/player/{id}', [PlayerController::class, 'update'])->name('players.update');
    Route::get('/player/logout', [PlayerController::class, 'logout'])->name('players.logout');
    // Team routes
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::post('/teams/delete', [TeamController::class, 'destroy'])->name('teams.destroy'); // Fixed method name
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/{team}/players/browse', [PlayerController::class, 'browseAll'])->name('teams.players.browse');
Route::post('/teams/{team}/players', [PlayerController::class, 'storeToTeam'])->name('teams.players.store');
Route::get('/teams/{team}/players/{player}', [PlayerController::class, 'show'])->name('teams.players.show');
Route::get('/teams/{team}/players/{player}/edit', [PlayerController::class, 'edit'])->name('teams.players.edit');
Route::put('/teams/{team}/players/{player}', [PlayerController::class, 'update'])->name('teams.players.update');
Route::delete('/teams/{team}/players/{player}', [PlayerController::class, 'removeFromTeam'])->name('teams.players.remove');
    // Booking routes
    Route::put('/bookings/{booking}/cancel', [BookingController::class, 'destroy'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::post('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::get('/booking/{player}/{field}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/api/fields/{fieldId}/booked-slots', [BookingController::class, 'getBookedSlots']);
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

   
    Route::get('/fields/{field}/available-slots', [BookingController::class, 'checkAvailability']);
});

// Tournament routes
Route::prefix('tournaments')->name('tournaments.')->group(function() {
    // Browse tournaments (public accessible)
    Route::get('/browse', [TournamentController::class, 'browse'])->name('browse');
    
    // Show tournament details (public accessible)
    Route::get('/{tournament}', [TournamentController::class, 'show'])->name('show');
    
    // Protected routes (require authentication)
    Route::middleware('auth')->group(function() {
        // My tournaments
        Route::get('/my/tournaments', [TournamentController::class, 'myTournaments'])->name('my');
        
        // Join tournament (requires POST method)
        Route::post('/{tournament}/join', [TournamentController::class, 'join'])->name('join');
    });
});



// Routes with custom middleware
Route::middleware(['auth', 'store.session', 'no.team'])->group(function () {
    // Routes that require the no.team middleware
});