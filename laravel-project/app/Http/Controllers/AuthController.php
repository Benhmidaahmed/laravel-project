<?php

namespace App\Http\Controllers;

use App\Models\utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
     $validated = $request->validate([
    'email' => 'required|email|unique:utilisateur',
    'password' => 'required|min:6',
    'first_name' => 'required',
    'last_name' => 'required',
    'roles' => 'required|in:STUDENT,PSYCHOLOGIST,ADMIN', // NOT an array
]);


      $user = utilisateur::create([
    'email' => $validated['email'],
    'password' => Hash::make($validated['password']),
    'first_name' => $validated['first_name'],
    'last_name' => $validated['last_name'],
    'roles' => $validated['roles'], // This is now a string
    'enabled' => true,
]);


        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => JWTAuth::user(),
        ]);
    }
}
