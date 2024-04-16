<?php

use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', function(){

});
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/userData', [UserController::class, 'userData']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/flights/{airportId}', [FlightController::class, 'getFlights']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/create-ticket', [TicketController::class, 'create']);
});
