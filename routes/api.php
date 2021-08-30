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

Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/init', [PageController::class, 'init']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/me', function (Request $request) {
        //sleep(4);
        return response()->json(['user'=>auth()->user()]);
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    Route::prefix('reservation')->name('reservation.')->group(function () {

        Route::post('/step_1_check_date', [ReservationController::class, 'step_1_check_date']);
    
        Route::post('/step_3_confirmation', [ReservationController::class, 'step_3_confirmation']);
    
        Route::post('/step_4_finalize', [ReservationController::class, 'step_4_finalize']);
    
        Route::post('/dicount_code', [ReservationController::class, 'dicount_code']);
    });
    
});
