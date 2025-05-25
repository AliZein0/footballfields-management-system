<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerSportFieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\StoreUserSession;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerTournamentController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\Admin\AdminSportFieldController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminBookingController;


// Public Routes (no authentication required)
Route::get('/fields/search', [PlayerSportFieldController::class, 'search'])->name('fields.search');
// Add this at the top of your routes file
Route::get('/fields/all', [PlayerSportFieldController::class, 'allFields'])->name('fields.all');
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
    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::post('/teams/delete', [TeamController::class, 'destroy'])->name('teams.destroy'); // Fixed method name
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

Route::post('/teams/{team}/players', [PlayerController::class, 'storeToTeam'])->name('teams.players.store');

Route::get('/teams/{team}/players/{player}/edit', [PlayerController::class, 'edit'])->name('teams.players.edit');
Route::put('/teams/{team}/players/{player}', [PlayerController::class, 'update'])->name('teams.players.update');

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


Route::prefix('tournaments')->name('tournaments.')->group(function() {
    // Browse tournaments (public accessible)
    Route::get('/browse', [PlayerTournamentController::class, 'browse'])->name('browse');
    
    // Show tournament details (public accessible)
    Route::get('/{tournament}', [PlayerTournamentController::class, 'show'])->name('show');
    
    // Protected routes (require authentication)
    Route::middleware('auth')->group(function() {
        // My tournaments
        Route::post('/{tournament}/cancel', [PlayerTournamentController::class, 'cancelRegistration'])->name('cancel');
        
        // Join tournament (requires POST method)
        Route::post('/{tournament}/join', [PlayerTournamentController::class, 'join'])->name('join');
    });

    
});




// Team Invitations
Route::middleware(['auth'])->group(function () {
    // Team Captain Routes
    Route::post('/teams/{team}/invite', [TeamInvitationController::class, 'invite'])->name('invitations.invite');
    Route::get('/teams/{team}/invitations', [TeamInvitationController::class, 'teamInvitations'])->name('invitations.team');
    Route::post('/invitations/{invitation}/cancel', [TeamInvitationController::class, 'cancel'])->name('invitations.cancel');
    
    // Player Routes
    Route::get('/invitations', [TeamInvitationController::class, 'playerInvitations'])->name('invitations.player');
    Route::post('/invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{invitation}/decline', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
    
    // Team Player Management
    Route::get('/teams/{team}/players/browse', [TeamController::class, 'browsePlayers'])->name('teams.players.browse');
    Route::get('/teams/{team}/players', [TeamController::class, 'showPlayers'])->name('teams.players');
    Route::get('/teams/{team}/players/{player}', [TeamController::class, 'showPlayer'])->name('teams.players.show');
    Route::delete('/teams/{team}/players/{player}', [TeamController::class, 'removePlayer'])->name('teams.players.remove');
    Route::post('/teams/{team}/leave', [TeamController::class, 'leaveTeam'])->name('teams.leave');
      Route::get('/teams/{team}/matches', [TeamController::class, 'showMatches'])->name('teams.matches');
    
    // Optional: If you want to allow viewing matches without specifying team ID
    // (will show current user's team matches)
   
});


// Routes with custom middleware
Route::middleware(['auth', 'store.session', 'no.team'])->group(function () {
    // Routes that require the no.team middleware
});


// Admin routes

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management (View & Toggle Status only)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
     Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminBookingController::class, 'index'])->name('index');
        Route::get('/{booking}', [App\Http\Controllers\Admin\AdminBookingController::class, 'show'])->name('show');
        Route::patch('/{booking}/status', [App\Http\Controllers\Admin\AdminBookingController::class, 'updateStatus'])->name('update-status');
    });
    // Sport Fields Management (View & Toggle Status only)
    Route::get('/fields', [AdminSportFieldController::class, 'adminFieldsIndex'])->name('fields.index');
    Route::get('/fields/{field}', [AdminSportFieldController::class, 'show'])->name('fields.show');
    Route::patch('/fields/{field}/toggle-status', [AdminSportFieldController::class, 'toggleStatus'])->name('fields.toggle-status');
        Route::get('/fields/{field}/reviews', [AdminSportFieldController::class, 'showFieldReviews'])->name('fields.reviews');
    // Payment Management (View & Verify/Reject only)
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
});
    
