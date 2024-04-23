<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', function(){

});
Route::post('/register', [UserController::class, 'register']);
Route::post('/register-admin', [UserController::class, 'registerAdmin']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user-data', [UserController::class, 'userData']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/flights/{airportId}', [FlightController::class, 'getFlights']);
    Route::get('/airports', [AirportController::class, 'getAirports']);
    Route::get('/airlines', [AirlineController::class,'index']);
    Route::get('/planes', [PlaneController::class,'index']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/create-ticket', [TicketController::class, 'create']);
});

Route::middleware(['auth:sanctum','CheckAdmin'])->group(function(){
    Route::get('test', function () {
        return response()->json(["message" => "you are an admin"]);
    });
    /**
     * the ability to create airlines
     * the ability to create planes linked to airlines
     * the ability to add airports 
     * the ability to create flights
     */
    Route::post("add/airline",[AirlineController::class,"create"]);
    Route::post("add/plane",[PlaneController::class,"create"]);
    Route::post("add/airport",[AirportController::class,"create"]);
    Route::post("add/flight",[FlightController::class,"create"]);
});
