<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirlinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ! i'm lazy so i won't rename this
        $relativePath = __DIR__."/init/airlines.json";
        $airlines = file_get_contents($relativePath);
        $airlines = json_decode($airlines,true);
        $airlines = $airlines["airlines"];
        foreach($airlines as $airline){
            Airline::create([
                "name" => $airline["name"],
            ]);
          } 
    }
}
