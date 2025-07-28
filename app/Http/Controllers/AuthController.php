<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'FullName'                  => 'required|string|max:255',
            'Email'                 => 'required|string|email|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            'Phone'                 => 'required|string|max:20',
            'NationalID'           => 'required|digits_between:6,20',
            'DocURL' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'EmailNotifications'   => 'boolean',
            'insurranceNo'          => 'required|integer',
            'TermsAndConditions'  => 'required|accepted'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $filePath = $request->file('DocURL')->store('documents', 'public');
        $user = User::create([
            'fullName' => $request->FullName,
            'email' => $request->Email,
            'password' => Hash::make($request->password),
            'phone'    => $request->Phone,
            'nationalID' => $request->NationalID,
            'docURL'     => $filePath,
            'emailNotifications' => $request->EmailNotifications ?? false,
            'insurranceNo' => $request->insurranceNo,
            'termsAndConditions' => $request->TermsAndConditions ? 1 : 0,
        ]);



        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully!',
            'user'    => $user,
            'token'   => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authRepository->login($request->validated());
        
        if (!$result) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحة'], 401);
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

    public function updateProfile(Request $request)
{
    $user = JWTAuth::parseToken()->authenticate();

    $request->validate([
        'phone' => 'nullable|string|max:20',
        'insurranceNo' => 'nullable|string|max:50',
    ]);

    if ($request->has('phone')) {
        $user->phone = $request->phone;
    }

    if ($request->has('insurranceNo')) {
        $user->insurranceNo = $request->insurranceNo;
    }

    $user->save();

    return response()->json([
        'message' => 'تم تحديث البيانات بنجاح',
        'user' => $user
    ]);
}


}