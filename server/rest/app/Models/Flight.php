<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = [
        "plane_id",
        "airport_id",
        "airport_destination_id",
        "flight_destination",
        "flight_arrival",
    ];
}
