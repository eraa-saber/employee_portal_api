<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        // List all posts
        return response()->json(Post::all());
    }

    public function store(Request $request): JsonResponse
    {
        // Add a new post
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function show(Post $post): JsonResponse
    {
        // Show a single post
        return response()->json($post);
    }

    public function update(Request $request, Post $post): JsonResponse
    {
        // Edit a post
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);
        $post->update($validated);
        return response()->json($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        // Delete a post
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}