<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relativePath = __DIR__."/init/flights.json";
        $flights = file_get_contents($relativePath);
        $flights = json_decode($flights,true);
        $flights = $flights["flights"];
        foreach($flights as $flight){
            Flight::create([
                "plane_id" => $flight["plane_id"],
                "airport_id" => $flight["airport_id"],
                "airport_destination_id" => $flight["airport_destination_id"],
                "flight_destination" => $flight["destination"], // departure not destination
                "flight_arrival" => $flight["arrival"],
            ]);
          } 
    }
}
