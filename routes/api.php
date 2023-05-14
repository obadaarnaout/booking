<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EscapeRoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login',[AuthController::class, 'login']);

Route::prefix('/escape-rooms')->group(function () {
    Route::get('/', [EscapeRoomController::class, 'index']);
    Route::get('/{id}', [EscapeRoomController::class, 'show']);
    Route::get('/{id}/time-slots', [EscapeRoomController::class, 'timeSlots']);
});

Route::middleware(['auth:sanctum'])->prefix('/bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/', [BookingController::class, 'index']);
    Route::delete('/{id}', [BookingController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
