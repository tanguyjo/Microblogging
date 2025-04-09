<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = Like::firstOrCreate($validated);
        return response()->json($like, 201);
    }

    public function destroy(Like $like)
    {
        $like->delete();
        return response()->noContent();
    }
}
