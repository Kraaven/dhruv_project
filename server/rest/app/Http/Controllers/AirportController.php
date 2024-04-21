<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

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
}
