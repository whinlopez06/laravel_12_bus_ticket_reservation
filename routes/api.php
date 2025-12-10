<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusDetailController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BusScheduleBookingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BusScheduleController;
use App\Models\BusDetail;
use App\Models\BusScheduleBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');


// Bus Detail Route
Route::get('/bus-detail/buses/', action: [BusDetailController::class, 'getBuses']);


// Bus Location
Route::get('/bus-location', [LocationController::class, 'index']);


// Bus Schedule
Route::get('/bus-schedule/search',[BusScheduleController::class, 'searchBusSchedule']);
Route::get('/bus-schedule/booking/{id}', [BusScheduleController::class, 'getBusScheduleById']);

Route::post('/bus-schedule/store', [BusScheduleController:: class,'store']);
Route::get('/bus-schedule/index', [BusScheduleController:: class,'index']);
Route::get('/bus-schedule/summary', [BusScheduleController::class, 'getBusScheduleSummary']);


// Bus Schedule Booking
// Route::get();
Route::post('/bus-schedule-booking/store', [BusScheduleBookingController:: class,'store']);
Route::get('/bus-schedule-booking/{scheduleId}', action: [BusScheduleBookingController::class, 'getBusScheduleBookingByScheduleId']);




