<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'status' => 'in:draft,published',
            'visibility' => 'in:public,private,followers',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'status' => $validated['status'] ?? 'draft',
            'visibility' => $validated['visibility'] ?? 'public',
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post->load(['user', 'hashtags', 'comments']);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'status' => 'in:draft,published',
            'visibility' => 'in:public,private,followers',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $post->delete();
        return response()->noContent();
    }

    public function hashtags(Post $post)
    {
        return $post->hashtags;
    }

    public function comments(Post $post)
    {
        return $post->comments()->with('user')->get();
    }

    public function likes(Post $post)
    {
        return $post->likes()->with('user')->get();
    }

    public function userPosts($userId)
    {
        return Post::where('user_id', $userId)
            ->with(['user', 'hashtags', 'comments'])
            ->get();
    }
}
