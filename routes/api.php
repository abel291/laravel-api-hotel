<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('reservation')->name('reservation.')->group(function () {

        Route::post('/step_1_check_date', [ReservationController::class, 'step_1_check_date'])->name('step_1_check_date');

        Route::post('/step_4_confirmation', [ReservationController::class, 'step_4_confirmation'])->name('step_4_confirmation');
});