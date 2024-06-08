<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'password' => 'required'
        ]);
        
        // Attempt to log the user in
        if (auth()->attempt($request->only('name', 'password'))) {
            // If successful, return the user
            return response()->json([
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('api')->plainTextToken,
            ], 200);
        }
        
        // If unsuccessful, return an error message
        return response()->json([
            'message' => 'name or password is incorrect'
        ], 401);
    }

    public function register(Request $request) {
       try{
            // Validate the request
            $request->validate([
                'name' => 'required|string|unique:users,name',
                "email" => "required|email|unique:users,email",
                'password' => 'required',
            ]);
            
            // Create the user
            $user = User::create([
                'name' => $request->name,
                "email" => $request->email,
                'password' => Hash::make($request->password),
                "role" => "user"
            ]);
            
            // Log the user in
            auth()->login($user);
            
            // Create a token for the user
            $token = $user->createToken('api')->plainTextToken;
            
            // Return the user and token
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            // If something goes wrong, return an error message
            return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage(),                
            ], 500);
        }       
    }

    // public function logout(Request $request) {
    //    try{
    //         // Revoke the token that was used to authenticate the current request...
    //         $user = User::find($request->id);
    //         $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            
    //         // Return a success response
    //         return response()->json([
    //             'message' => 'Logged out'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // If something goes wrong, return an error message
    //         return response()->json([
    //             'message' => 'Terjadi Kesalahan',
    //             'error' => $e->getMessage(),                
    //         ], 500);
    //    }
    // }
}
