<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return User::all();
    }

    // GET /api/users/{user}
    public function show(User $user)
    {
        return $user->load(['posts', 'followers', 'following']);
    }

    public function followers(User $user)
    {
        return $user->followers()->with('follower')->get();
    }

    public function following(User $user)
    {
        return $user->following()->with('followed')->get();
    }

    // GET /api/user (profile de l'utilisateur connecté)
    public function profile()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'bio' => $user->bio,
            'avatar_url' => $user->avatar_url
        ]);
    }

    // PUT /api/user (mise à jour du profil)
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string',
            'avatar_url' => 'nullable|url'
        ]);

        $user->update($validated);

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'bio' => $user->bio,
            'avatar_url' => $user->avatar_url
        ]);
    }
}

