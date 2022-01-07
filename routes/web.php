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
use App\Http\Livewire\Admin\Discount\ListDiscount;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

//  Route::middleware(['auth:sanctum', 'verified'])->name('dashboard.')->prefix('dashboard')
//  ->group(function () {

//      Route::get('/', function () {
//          return view('dashboard');
//      })->name('home');

//      //Route::get('/users', ListUsers::class)->name('users');
//      Route::get('/rooms', ListRooms::class)->name('rooms');
//      Route::get('/complements', ListComplements::class)->name('complements');
//      Route::get('/galleries', ListGalleries::class)->name('galleries');
//      Route::get('/reservations', ListReservations::class)->name('reservations');
//      Route::get('/blog', ListPosts::class)->name('blog');
//      Route::get('/tags', ListTags::class)->name('tags');
//      Route::get('/pages', ListPages::class)->name('pages');
//      Route::get('/discounts', ListDiscount::class)->name('discounts');
//  });

// Route::get('/', [HomeController::class, 'home'])->name('home');
// Route::get('/about-us', [HomeController::class, 'about'])->name('about_us');
// Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
// Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
// Route::get('/room/{room}', [HomeController::class, 'room'])->name('room');
// Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
// Route::get('/blog/post/{slug}', [HomeController::class, 'post'])->name('post');
// Route::get('/terms-conditions', [HomeController::class, 'terms_conditions'])->name('terms-conditions');
// Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
// Route::get('/cancellation-policies', [HomeController::class, 'cancellation_policies'])->name('cancellation-policies');
// Route::get('/cancellation-reservation', [HomeController::class, 'cancellation_reservation'])->name('cancellation-reservation');
// Route::get('/cookies-policy', [HomeController::class, 'cookies_policy'])->name('cookies-policy');


// Route::prefix('reservation')->name('reservation.')->group(function () {

//     Route::get('/', [ReservationController::class, 'index'])->name('index');

//     Route::post('/step_1_check_date', [ReservationController::class, 'step_1_check_date'])->name('step_1_check_date');

//     Route::post('/step_3_confirmation', [ReservationController::class, 'step_3_confirmation'])->name('step_3_confirmation');
    
//     Route::post('/step_4_finalize', [ReservationController::class, 'step_4_finalize'])->name('step_4_finalize');

//     Route::post('/dicount_code', [ReservationController::class, 'dicount_code'])->name('dicount_code');

//     Route::get('/report_pdf', [ReservationController::class, 'report_pdf'])->name('report_pdf')->whereNumber('order');

//  });
Route::get('/reservation/report_pdf', [ReservationController::class, 'report_pdf'])->name('report_pdf')->whereNumber('order');