<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Authenticate user and generate JWT token
     *
     * @param array $credentials
     * @return array|null
     */
    public function login(array $credentials): ?array
    {
        // First check if user exists
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return null;
        }

        // Check password
        if (!Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        // Attempt to authenticate with JWT
        if (!$token = auth('api')->attempt($credentials)) {
            return null;
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user()
        ];
    }

    /**
     * Register a new user
     *
     * @param array $userData
     * @return array
     */
    public function register(array $userData): array
    {
        // Hash the password
        $userData['password'] = Hash::make($userData['password']);

        // Create user
        $user = User::create($userData);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        return [
            'message' => 'User successfully registered',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer'
        ];
    }

    /**
     * Logout user
     *
     * @return bool
     */
    public function logout(): bool
    {
        auth('api')->logout();
        return true;
    }

    /**
     * Get current authenticated user
     *
     * @return mixed
     */
    public function getUser()
    {
        return auth('api')->user();
    }

    /**
     * Refresh JWT token
     *
     * @return array
     */
    public function refresh(): array
    {
        $token = JWTAuth::refresh();
        
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user()
        ];
    }
} 