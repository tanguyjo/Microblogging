<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['user', 'hashtags'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'status' => 'in:draft,published',
            'visibility' => 'in:public,private,followers',
        ]);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post->load(['user', 'hashtags', 'comments']);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }

    public function hashtags(Post $post)
    {
        return $post->hashtags;
    }
}
