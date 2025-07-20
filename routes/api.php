<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Test route to verify API is working
Route::get('test', function () {
    return response()->json(['message' => 'API routes are working!']);
});

// Authentication routes
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('auth/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
Route::get('auth/user-profile', [AuthController::class, 'userProfile'])->middleware('auth:api');

// Posts routes (protected by JWT authentication)
/*Route::middleware('auth:api')->group(function () {
    Route::get('/posts', function () {
        $user = auth()->user();
        if (!$user || !$user->can('posts.list')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json(\App\Models\Post::all());
    });

    Route::post('/posts', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        if (!$user || !$user->can('posts.add')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $post = \App\Models\Post::create($validated);
        return response()->json($post, 201);
    });

    Route::get('/posts/{post}', function (\App\Models\Post $post) {
        $user = auth()->user();
        if (!$user || !$user->can('posts.list')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($post);
    });

    Route::put('/posts/{post}', function (\Illuminate\Http\Request $request, \App\Models\Post $post) {
        $user = auth()->user();
        if (!$user || !$user->can('posts.edit')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);
        $post->update($validated);
        return response()->json($post);
    });

    Route::patch('/posts/{post}', function (\Illuminate\Http\Request $request, \App\Models\Post $post) {
        $user = auth()->user();
        if (!$user || !$user->can('posts.edit')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);
        $post->update($validated);
        return response()->json($post);
    });

    Route::delete('/posts/{post}', function (\App\Models\Post $post) {
        $user = auth()->user();
        if (!$user || !$user->can('posts.delete')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }); 
}*/ 