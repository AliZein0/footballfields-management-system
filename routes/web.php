<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\FieldController;
use Illuminate\Support\Facades\Route;


Route::get('/players', [PlayerController::class, 'index'])->name('players.index');


Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');

Route::get('/show', [PlayerController::class, 'show'])->name('players.profile');



// Add this to your routes/web.php or routes/api.php file
Route::get('/fields/search', [FieldController::class, 'search'])->name('fields.search');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('sport_field.show');
// Then in your FieldController.php file, add this method:
