<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Utilisateur;
use App\Services\AuthService;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    protected $authService;
    protected $fileStorageService;

    public function __construct(AuthService $authService, FileStorageService $fileStorageService)
    {
        $this->authService = $authService;
        $this->fileStorageService = $fileStorageService;
    }

    // Student Registration (with optional profile image)
    public function registerStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phoneNumber' => 'nullable|string',
            'studentCardNumber' => 'required|string',
            'university' => 'required|string',
            'studyLevel' => 'required|string',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 422);
        }

        $user = new Utilisateur();
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->numTel = $request->phoneNumber;
        $user->studentCardNumber = $request->studentCardNumber;
        $user->university = $request->university;
        $user->studyLevel = $request->studyLevel;

        // Handle profile image upload
        if ($request->hasFile('profileImage')) {
            $imagePath = $this->fileStorageService->storeFile($request->file('profileImage'));
            $user->urlImage = $imagePath;
        }

        // Register the user with the 'STUDENT' role
        $this->authService->register($user, 'STUDENT');

        return response()->json(['message' => 'Student registration successful'], 200);
    }

    // Psychologist Registration (with optional profile image)
    public function registerPsychologist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phoneNumber' => 'nullable|string',
            'adeliNumber' => 'required|string',
            'specialization' => 'required|string',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->numTel = $request->phoneNumber;
        $user->adeliNumber = $request->adeliNumber;
        $user->specialization = $request->specialization;

        // Handle profile image upload
        if ($request->hasFile('profileImage')) {
            $imagePath = $this->fileStorageService->storeFile($request->file('profileImage'));
            $user->urlImage = $imagePath;
        }

        // Register the user with the 'Psy' role
        $this->authService->register($user, 'Psy');

        return response()->json(['message' => 'Psychologist registration successful'], 200);
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($this->authService->login($credentials)) {
            return response()->json(['message' => 'Login successful']);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    // Confirm Account via Token
    public function confirmAccount(Request $request)
    {
        $token = $request->query('token');
        $confirmationMessage = $this->authService->confirmToken($token);

        return response()->json(['message' => $confirmationMessage]);
    }
}
