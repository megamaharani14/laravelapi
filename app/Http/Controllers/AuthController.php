<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user'
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
            
        ]);

        // Membuat token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan respon
        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required',     
        ]);

        //cek user berdasarkan email
        $user = User::where('email', $request->email)->first();

        //cek password
        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->json (['message' => 'Invalid'], 401);
        }

        //membuat token
        $token = $user ->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token ], 200);
    }


    

}