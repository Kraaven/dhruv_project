<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function getFlights($airportId){
        $flights = Flight::join('planes', 'flights.plane_id', '=', 'planes.id')
        ->join('airports as departure_airport', 'flights.airport_id', '=', 'departure_airport.id')
        ->join('airports as destination_airport', 'flights.airport_destination_id', '=', 'destination_airport.id')
        ->select(
            'flights.id as flight_id',
            'planes.name as plane_name',
            'departure_airport.name as departure_airport_name',
            'destination_airport.name as destination_airport_name',
            'flights.flight_destination',
            'flights.flight_arrival',
            'planes.capacity'
        )
        ->where("departure_airport.id",$airportId)
        ->get();
        return response()->json(["flights" => $flights],200);
    }
}
