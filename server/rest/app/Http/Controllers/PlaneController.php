<?php

namespace App\Http\Controllers;

use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaneController extends Controller
{
    public function create(Request $request){
        $validation = Validator::make($request->all(),[
            "name" => "required|string",
            "capacity" => "integer|required",
            "airline_id" => "integer|required"
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->all(), 400);
        }
        $validated = $validation->validated();
        $plane = Plane::create([
            "name" => $validated["name"],
            "capacity" => $validated["capacity"],
            "airline_id" => $validated["airline_id"]
        ]);
        return response()->json(["plane" => $plane,"message" => "Plane Created"],200);
    }

    public function index(){
        return response()->json(["planes" => Plane::all()],200);
    }
}
