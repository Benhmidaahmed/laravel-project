<?php

namespace App\Services;

use App\Models\User;
use App\Models\ConfirmationToken;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\CustomException;
use App\Services\JwtService;
use App\Services\ConfirmationTokenService;

class AuthService
{
    protected $userRepo;
    protected $tokenService;
    protected $emailService;
    protected $jwtService;

    public function __construct(
        UserRepository $userRepo,
        ConfirmationTokenService $tokenService,
        EmailService $emailService,
        JwtService $jwtService
    ) {
        $this->userRepo = $userRepo;
        $this->tokenService = $tokenService;
        $this->emailService = $emailService;
        $this->jwtService = $jwtService;
    }

    // Register a user (with email confirmation)
    public function register(User $user, $role)
    {
        // Check if the email is already registered
        if ($this->userRepo->findByEmail($user->email)) {
            return "Email already registered.";
        }

        // Hash password and set role
        $user->password = Hash::make($user->password);
        $user->roles = $role;
        $user->enabled = false;
        $user->save();

        // Create confirmation token
        $token = $this->tokenService->createToken($user);

        // Send confirmation email
        $link = url("/api/auth/confirm?token=" . $token->token);
        $body = "Click here to confirm your account: \n" . $link;
        $this->emailService->sendEmail($user->email, "Account Confirmation", $body);

        return "Registration successful! Please check your email to confirm your account.";
    }

    // Login the user and generate a JWT token
    public function login($email, $password)
    {
        // Check if the user exists
        $user = $this->userRepo->findByEmail($email);

        if (!$user) {
            throw new CustomException("Email or password is incorrect.");
        }

        // Check if the account is confirmed
        if (!$user->enabled) {
            throw new CustomException("Please confirm your email before logging in.");
        }

        // Authenticate the user
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new CustomException("Email or password is incorrect.");
        }

        // Generate JWT token
        $token = $this->jwtService->generateToken($user);

        // Return response with the token and role
        return [
            'token' => $token,
            'message' => "Login successful!",
            'role' => $user->roles,
        ];
    }

    // Confirm the user account using the token
    public function confirmToken($tokenValue)
    {
        $token = $this->tokenService->getToken($tokenValue);

        if (!$token || $token->expires_at->isBefore(now())) {
            return "Invalid or expired token.";
        }

        // Enable the user account
        $user = $token->user;
        $user->enabled = true;
        $user->save();

        // Delete the token after use
        $this->tokenService->deleteToken($token);

        return "Account successfully confirmed!";
    }
}
