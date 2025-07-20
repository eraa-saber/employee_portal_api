<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'FullName' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'Phone' => 'sometimes|string',
            'NationalID' => 'sometimes|digits:14',
            'DocURL' => 'sometimes|string',
            'EmailNotifications' => 'sometimes|boolean',
            'insuranceNo' => 'sometimes|integer',
            'TermsAndConditions' => 'sometimes|boolean',
        ]);
        $user = $this->userRepository->update($id, $validated);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = trim(strtolower($request->email));
        $user = $this->userRepository->findByEmailCaseInsensitive($email);
        if (!$user) {
            return response()->json(['error' => 'Email not found'], 404);
        }
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );
        // In a real app, send email here. For now, return the token for testing.
        return response()->json([
            'message' => 'Password reset link sent (token returned for testing)',
            'token' => $token
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $email = trim(strtolower($request->email));
        $token = $request->token;
        $user = $this->userRepository->findByEmailCaseInsensitive($email);
        if (!$user) {
            return response()->json(['error' => 'Email not found'], 404);
        }
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();
        if (!$record) {
            return response()->json(['error' => 'Invalid or expired token'], 400);
        }
        $this->userRepository->updatePassword($user, $request->password);
        // Optionally, delete the token after use
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        return response()->json(['message' => 'Password updated successfully.']);
    }
} 