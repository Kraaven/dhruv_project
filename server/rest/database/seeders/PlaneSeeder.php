<?php

namespace Database\Seeders;

use App\Models\Plane;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relativePath = __DIR__."/init/planes.json";
        $planes = file_get_contents($relativePath);
        $planes = json_decode($planes,true);
        $planes = $planes["planes"];
        foreach($planes as $plane){
            Plane::create([
                "name" => $plane["name"],
                "capacity" => $plane["capacity"],
                "airline_id" => $plane["airline_id"]
            ]);
          } 
    }
}
