<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $validated['post_id'],
        ]);

        return response()->json($like, 201);
    }

    public function destroy(Like $like)
    {
        if ($like->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $like->delete();
        return response()->noContent();
    }
}
