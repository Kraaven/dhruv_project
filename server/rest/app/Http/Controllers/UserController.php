<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function register(Request $request)
{
    $validation = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|string|unique:users',
        'password' => 'required|string',
        'age' => 'required|integer',
        'sex' => 'required|string|max:1'
    ]);
        
    if ($validation->fails()) {
        return response()->json($validation->errors()->all(), 400);
    }
        
    $validated = $validation->validated();

    try {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'age' => $validated['age'],
            'sex' => $validated['sex']
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function login(Request $request){
        $validation = Validator::make($request->all(),[
            "email"=>'required|string',
            'password'=>'required|string'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors()->all(),400);
        }
        $validated = $validation->validated();
        $user = User::where('email',$validated['email'])->first();
        if(!$user){
            return response()->json(['error'=>"Email Not registered"],400);
        }
        if(!Hash::check($validated['password'],$user->password)){
            return response()->json(['error'=>'Invalid Credentials'],400);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        return response()->json(['user'=>$user,'token'=>$token],200)->withCookie(cookie()->forever('at',$token));

    }
    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        $response =  [
            'message' => 'logged out'
        ];
        return response($response,200);

    }
    public function userData(Request $request){
        if(!$request->hasCookie("at")){
            return response()->json([
                'error' => "Unauthenticated"
            ],401);
        }
        if($token = \Laravel\Sanctum\PersonalAccessToken::findToken($request->cookie("at"))){
            $user = $token->tokenable;
        }
        else{
            return response()->json([
                'error' => "can't find the token"
            ],401);
        }
        if(is_null($user)){
            return response()->json([
                'error' => "Unauthenticated"
            ],401);
        }
        return response() -> json([
            'email' => $user->email,
            'name' => $user->name,
            'access_token' => $request -> cookie('at'),
        ],200);
    }
   
}
