<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request){
        $validation = Validator::make($request->all(),[
            "flight_destination" => "required|date_format:Y-m-d H:i:s",
            "flight_arrival" => "required|date_format:Y-m-d H:i:s",
            "plane_id" => "integer|required",
            "airport_id" => "integer|required",
            "airport_destination_id" => "integer|required"
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->all(), 400);
        }
        $validated = $validation->validated();
        $flight = Flight::create([
            "plane_id" => $validated["plane_id"],
            "airport_id" => $validated["airport_id"],
            "airport_destination_id" => $validated["airport_destination_id"],
            "flight_destination" => $validated["destination"], // departure not destination
            "flight_arrival" => $validated["arrival"],
        ]);
        return response()->json(["flight" => $flight,"message" => "Flight added!"]);
    }
}
