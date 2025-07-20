<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    /**
     * Authenticate user and generate JWT token
     *
     * @param array $credentials
     * @return array|null
     */
    public function login(array $credentials): ?array;

    /**
     * Register a new user
     *
     * @param array $userData
     * @return array
     */
    public function register(array $userData): array;

    /**
     * Logout user
     *
     * @return bool
     */
    public function logout(): bool;

    /**
     * Get current authenticated user
     *
     * @return mixed
     */
    public function getUser();

    /**
     * Refresh JWT token
     *
     * @return array
     */
    public function refresh(): array;
} 