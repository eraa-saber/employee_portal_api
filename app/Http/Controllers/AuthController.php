<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Routing\Controller;
use App\Repositories\Interfaces\AuthRepositoryInterface;


class AuthController extends Controller
{  protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
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
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            'phone'                 => 'required|string|max:20',
            'national_id'           => 'required|digits_between:6,20',
            'doc_url' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'email_notifications'   => 'boolean',
            'insurance_no'          => 'required|integer',
            'terms_and_conditions'  => 'required|accepted'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $filePath = $request->file('doc_url')->store('documents', 'public');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'national_id' => $request->national_id,
            'doc_url'     => $filePath,
            'email_notifications' => $request->email_notifications ?? false,
            'insurance_no' => $request->insurance_no,
            'terms_and_conditions' => $request->terms_and_conditions ? 1 : 0,
        ]);


        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully!',
            'user'    => $user,
            'token'   => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token'   => $token
        ]);
    }
}

