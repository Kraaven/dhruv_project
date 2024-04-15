<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relativePath = __DIR__."/init/airports.json";
        $airports = file_get_contents($relativePath);
        $airports = json_decode($airports,true);
        $airports = $airports["airports"];
        foreach($airports as $airport){
            Airport::create([
                "name" => $airport["name"],
            ]);
          } 
    }
}
