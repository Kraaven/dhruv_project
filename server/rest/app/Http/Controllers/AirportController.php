<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function getAirports()
    {
        $airports = Airport::select('airports.name', 'airports.id')
                    ->selectRaw('COUNT(flights.id) as flight_count')
                    ->leftJoin('flights', 'flights.airport_id', '=', 'airports.id')
                    ->groupBy('airports.id', 'airports.name')
                    ->get();

        return response()->json(['airports' => $airports], 200);
    }

    public function create(Request $request){
        $validation = Validator::make($request->all(),[
            "name" => "string|required"
        ]);
        $validated = $validation->validated();
        $airport = Airport::create([
            "name" => $validated["name"]
        ]);
        return response()->json(["airport" => $airport,"message" => "Airport added!"]);
    }
}
