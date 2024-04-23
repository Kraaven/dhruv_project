<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirlineController extends Controller
{
    public function create(Request $request){
        $validation = Validator::make($request->all(),[
            "name" => "string|required"
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->all(), 400);
        }
        $validated = $validation->validated();
        $airline = Airline::create([
            "name" => $validated["name"]
        ]);
        return response()->json(["airline" => $airline,"message" => "Airline added!"]);
    }
    public function index(){
        return response()->json(["airlines" => Airline::all()]);
    }
}
