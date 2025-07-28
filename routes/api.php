<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Post;

/**
 * Handle all OPTIONS requests (for CORS preflight)
 */
Route::options('/{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
})->where('any', '.*');

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API routes are working!']);
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware('auth:api');
Route::put('/update-profile', [AuthController::class, 'updateProfile']);

// Password reset
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/change-password', [UserController::class, 'changePassword']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    // User endpoints
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    // Posts
    Route::get('/posts', function () {
        return response()->json(Post::all());
    });

    Route::post('/posts', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $post = Post::create($validated);
        return response()->json($post, 201);
    });

    Route::get('/posts/{post}', function (Post $post) {
        return response()->json($post);
    });

    Route::put('/posts/{post}', function (Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);
        $post->update($validated);
        return response()->json($post);
    });

    Route::patch('/posts/{post}', function (Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);
        $post->update($validated);
        return response()->json($post);
    });

    Route::delete('/posts/{post}', function (Post $post) {
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    });

    // Requests
    Route::get('/requests', [\App\Http\Controllers\RequestController::class, 'index']);
});

Route::middleware('auth:api')->post('/salary-inquiry', [\App\Http\Controllers\SalaryInquiryController::class, 'inquire']);
Route::middleware('auth:api')->post('/profile/reset-password', [\App\Http\Controllers\ProfileController::class, 'resetPassword']);
