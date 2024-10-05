<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,admin',
                ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
     
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role'=>$request->role,
            'password' => Hash::make($request->password),
        ]);
    
        // Generate a token for the user
        // $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            // 'token' => $token,
        ], 200);
    
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $credentials =$request->only('email','password');
        if(!$token = auth()->attempt($credentials))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            // 'user' => auth()->user(),
            'token' => $token,
        ], 200);
    }




}
