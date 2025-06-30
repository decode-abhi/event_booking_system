<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/events', [EventController::class,'index']);
    Route::post('/event/create', [EventController::class,'store']);
    Route::post('/event/update/{id}', [EventController::class, 'update']);
    Route::post('/event/delete/{id}', [EventController::class, 'destroy']);
    Route::get('/event/show/{id}',[EventController::class, 'show']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/create', [BookingController::class, 'store']);
    Route::get('/booking/show/{booking}', [BookingController::class, 'show']);
    Route::put('/booking/update/{booking}', [BookingController::class, 'update']);
    Route::delete('/booking/delete/{booking}', [BookingController::class, 'destroy']);

});