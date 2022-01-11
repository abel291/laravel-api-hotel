<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('/auth/register', [AuthController::class, 'register']);

// Route::post('/auth/login', [AuthController::class, 'login']);

// Route::get('/init', [PageController::class, 'init']);

// Route::get('/galleries', [PageController::class, 'galleries']);

// Route::get('/blog', [PageController::class, 'blog']);

// Route::get('/post/{slug}', [PageController::class, 'post']);

Route::prefix('reservation')->name('reservation.')->group(function () {

    Route::get('/step_1_date', [ReservationController::class, 'step_1_date']);

    Route::get('/step_3_confirmation', [ReservationController::class, 'step_3_confirmation']);

    Route::post('/step_4_finalize', [ReservationController::class, 'step_4_finalize']);

    Route::get('/dicount_code', [ReservationController::class, 'dicount_code']);
});

Route::prefix('page')->name('page.')->group(function () {
    Route::get('home', [PageController::class, 'home'])->name('home');
    Route::get('rooms', [PageController::class, 'rooms'])->name('rooms');
    Route::get('about-us', [PageController::class, 'about_us'])->name('about_us');
    Route::get('contact', [PageController::class, 'contact'])->name('contact');
    Route::get('blog', [PageController::class, 'blog'])->name('blog');
    Route::get('posts', [PageController::class, 'posts'])->name('posts');
    
    Route::get('gallery', [PageController::class, 'gallery'])->name('gallery');
    Route::get('terms_conditions', [PageController::class, 'terms_conditions'])->name('terms_conditions');
    Route::get('privacy_policy', [PageController::class, 'privacy_policy'])->name('privacy_policy');
    Route::get('cookies_policy', [PageController::class, 'cookies_policy'])->name('cookies_policy');
    Route::get('cancellation_policies', [PageController::class, 'cancellation_policies'])->name('cancellation_policies');
});
Route::get('room/{slug}', [PageController::class, 'room'])->name('room');
Route::get('post/{slug}', [PageController::class, 'post'])->name('post');
