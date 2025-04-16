<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    // POST /api/follows
    public function store(Request $request)
    {
        $request->validate([
            'followed_id' => 'required|exists:users,id',
        ]);

        $followerId = Auth::id();
        $followedId = $request->input('followed_id');

        if ($followerId == $followedId) {
            return response()->json(['error' => 'You cannot follow yourself.'], 422);
        }

        $follow = Follow::firstOrCreate([
            'follower_id' => $followerId,
            'followed_id' => $followedId,
        ]);

        return response()->json($follow, 201);
    }

    // DELETE /api/follows/{follow}
    public function destroy(Follow $follow)
    {
        if ($follow->follower_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $follow->delete();
        return response()->noContent();
    }

    // GET /api/users/{user}/followers
    public function followers(User $user)
    {
        return $user->followers()->with('follower')->get();
    }

    // GET /api/users/{user}/following
    public function following(User $user)
    {
        return $user->following()->with('followed')->get();
    }
    
    
    public function followByUsername($username)
{
    $follower = Auth::user();
    $followed = User::where('username', $username)->firstOrFail();

    // Empêche de suivre deux fois
    if (!$follower->following()->where('followed_id', $followed->id)->exists()) {
        $follower->following()->attach($followed->id);
    }

    return response()->json(['message' => 'Followed successfully']);
}

public function unfollowByUsername($username)
    {
        $follower = Auth::user();
        $followed = User::where('username', $username)->firstOrFail();

        $follower->following()->detach($followed->id);

        return response()->json(['message' => 'Unfollowed successfully']);
    }
}
