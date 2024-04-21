<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            "seat" => ["required", "string", "unique:tickets", "regex:/^[A-Z]\d+$/"], 
            "flight_id" => "required|integer",
        ]);
             
        if ($validation->fails()) {
            return response()->json($validation->errors()->all(), 400);
        }
        $validated = $validation->validated();
        $userId = $request->user()->id;
        $ticket = Ticket::create([
            "seat" => $validated["seat"],
            "user_id" => $userId,
            "flight_id" => $validated["flight_id"]
        ]);
        return response()->json(["message"=>"ticket booked!"]);
    }
}
