<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Users\ListUsers;
use App\Http\Livewire\Admin\Rooms\ListRooms;
use App\Http\Livewire\Admin\Complements\ListComplements;
use App\Http\Livewire\Admin\Experiences\ListExperiences;
use App\Http\Livewire\Admin\Galleries\ListGalleries;
use App\Http\Livewire\Admin\Reservations\ListReservations;
use App\Http\Livewire\Admin\Blog\ListPosts;
use App\Http\Livewire\Admin\Blog\ListTags;
use App\Http\Livewire\Admin\Pages\ListPages;

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

// Route::get('/', function () {
//     return view('welcome');
// });

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

Route::middleware(['auth:sanctum', 'verified'])->name('dashboard.')->prefix('dashboard')
->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::get('/users', ListUsers::class)->name('users');
    Route::get('/rooms', ListRooms::class)->name('rooms');
    Route::get('/complements', ListComplements::class)->name('complements');
    Route::get('/experiences', ListExperiences::class)->name('experiences');
    Route::get('/galleries', ListGalleries::class)->name('galleries');
    Route::get('/reservations', ListReservations::class)->name('reservations');
    Route::get('/blog', ListPosts::class)->name('blog');
    Route::get('/tags', ListTags::class)->name('tags');
    Route::get('/pages', ListPages::class)->name('pages');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about-us');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
Route::get('/room/{room}', [HomeController::class, 'room'])->name('room');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/post/{slug}', [HomeController::class, 'post'])->name('blog');



Route::prefix('reservation')->name('reservation.')->group(function () {

    Route::get('/', [ReservationController::class, 'index'])->name('index');

    Route::post('/step_1_check_date', [ReservationController::class, 'step_1_check_date'])->name('step_1_check_date');

    Route::post('/step_4_confirmation', [ReservationController::class, 'step_4_confirmation'])->name('step_4_confirmation');
    
    Route::post('/step_5_finalize', [ReservationController::class, 'step_5_finalize'])->name('step_5_finalize');

});