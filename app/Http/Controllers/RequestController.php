<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Fetch requests for the authenticated user
        $requests = $user->requests()->latest()->get();

        return response()->json($requests);
    }
}
