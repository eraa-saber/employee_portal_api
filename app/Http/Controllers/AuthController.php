<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authRepository->register($request->validated());
        
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authRepository->login($request->validated());
        
        if (!$result) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
        return response()->json($result);
    }

    public function logout()
    {
        $this->authRepository->logout();
        
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function userProfile()
    {
        $user = $this->authRepository->getUser();
        
        return response()->json($user);
    }

    public function refresh()
    {
        $result = $this->authRepository->refresh();
        
        return response()->json($result);
    }
}