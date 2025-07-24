<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class ProfileController extends Controller
{
    public function resetPassword(Request $request, UserService $userService)
    {
        $result = $userService->resetPassword($request, auth()->user());
        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }
        return response()->json(['message' => $result['message']]);
    }
} 