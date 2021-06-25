<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users\ListUsers;
use App\Http\Livewire\Rooms\ListRooms;
use App\Http\Livewire\Complements\ListComplements;
use App\Http\Livewire\Experiences\ListExperiences;
use App\Http\Livewire\Galleries\ListGalleries;
use App\Http\Livewire\Reservations\ListReservations;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', ListUsers::class)->name('users');
    Route::get('/rooms', ListRooms::class)->name('rooms');
    Route::get('/complements', ListComplements::class)->name('complements');
    Route::get('/experiences', ListExperiences::class)->name('experiences');
    Route::get('/galleries', ListGalleries::class)->name('galleries');
    Route::get('/reservations', ListReservations::class)->name('reservations');
});
