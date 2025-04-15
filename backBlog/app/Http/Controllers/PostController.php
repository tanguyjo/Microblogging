<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::withCount(['likes', 'comments'])
    ->with('user:id,username')
    ->orderBy('created_at', 'desc')
    ->get()
    ->map(function ($post) {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'status' => $post->status,
            'visibility' => $post->visibility,
            'created_at' => $post->created_at,
            'author' => $post->user->username ?? 'Unknown',
            'likes' => $post->likes_count,
            'comments' => $post->comments_count,
        ];
    });

    return response()->json($posts);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string',
        'content' => 'nullable|string',
        'status' => 'in:draft,published',
        'visibility' => 'in:public,private,followers',
        'hashtags' => 'nullable|array',
        'hashtags.*' => 'string',
    ]);

    $post = Post::create([
        'user_id' => Auth::id(),
        'title' => $validated['title'],
        'content' => $validated['content'] ?? null,
        'status' => $validated['status'] ?? 'draft',
        'visibility' => $validated['visibility'] ?? 'public',
    ]);

    if (!empty($request->hashtags)) {
        $hashtagIds = [];

        foreach ($request->hashtags as $tagName) {
            $tagName = trim($tagName);
            $tagName = ltrim($tagName, '#');
            if (!$tagName) continue;

            $hashtag = \App\Models\Hashtag::firstOrCreate(['name' => $tagName]);
            $hashtagIds[] = $hashtag->id;
        }

        $post->hashtags()->sync($hashtagIds);
    }

    return response()->json($post->load('hashtags'), 201);
}

    public function show(Post $post)
{
    $post->load([
        'user:id,username',
        'hashtags',
        'comments.user:id,username'
    ]);

    return response()->json([
        'id' => $post->id,
        'user_id' => $post->user_id,
        'title' => $post->title,
        'content' => $post->content,
        'status' => $post->status,
        'visibility' => $post->visibility,
        'created_at' => $post->created_at,
        'updated_at' => $post->updated_at,
        'user' => $post->user,
        'likes' => $post->likes()->count(),
        'tags' => $post->hashtags->pluck('name'),
        'comments_data' => $post->comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
                'user' => $comment->user,
            ];
        }),
    ]);
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
