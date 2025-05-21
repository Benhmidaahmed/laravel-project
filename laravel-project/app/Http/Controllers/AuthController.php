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
        'password' => 'required|min:6|confirmed',
        'first_name' => 'required',
        'last_name' => 'required',
        'num_tel' => 'required',
        'roles' => 'required|in:STUDENT,PSYCHOLOGIST,ADMIN', // Correction de STUDENT
        // Champs étudiants
        'student_card_number' => 'required_if:roles,STUDENT',
        'university' => 'required_if:roles,STUDENT',
        'study_level' => 'required_if:roles,STUDENT',
        // Champs psychologues
        'adeli_number' => 'required_if:roles,PSYCHOLOGIST',
        'specialization' => 'required_if:roles,PSYCHOLOGIST',
    ]);

    $userData = [
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'num_tel' => $validated['num_tel'],
        'roles' => $validated['roles'],
        'enabled' => true,
    ];

    // Gestion des champs spécifiques
    if ($validated['roles'] === 'STUDENT') {
        $userData['student_card_number'] = $validated['student_card_number'];
        $userData['university'] = $validated['university'];
        $userData['study_level'] = $validated['study_level'];
    } else if ($validated['roles'] === 'PSYCHOLOGIST') {
        $userData['adeli_number'] = $validated['adeli_number'];
        $userData['specialization'] = $validated['specialization'];
    }

    // Gestion de l'image
    if ($request->hasFile('url_image')) {
        $path = $request->file('url_image')->store('profile_images', 'public');
        $userData['url_image'] = $path;
    }

    $user = utilisateur::create($userData);

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
    $user = JWTAuth::user(); // Récupère l'utilisateur authentifié

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => JWTAuth::factory()->getTTL() * 60,
        'user' => $user,
        // Ajoutez ces champs :
        'token' => $token, // Champ attendu par le frontend
        'role' => $user->roles, // Assurez-vous que 'roles' existe dans votre modèle User
        'user_id' => $user->id,
    ]);
}
}
