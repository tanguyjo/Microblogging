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

    // GET /api/users/{username}
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        // Charger les relations nécessaires
        $user->loadCount(['posts', 'followers', 'following']);
        
        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'bio' => $user->bio,
            'avatar_url' => $user->avatar_url,
            'posts_count' => $user->posts_count,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count
        ]);
    }

    public function followers(User $user)
    {
        return $user->followers()->with('follower')->get();
    }

    public function following(User $user)
    {
        return $user->following()->with('followed')->get();
    }

    // GET /api/user (profil de l'utilisateur connecté)
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Charger les relations nécessaires
        $user->loadCount(['posts', 'followers', 'following']);

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'bio' => $user->bio,
            'avatar_url' => $user->avatar_url,
            'posts_count' => $user->posts_count,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count
        ]);
    }

    // PUT /api/user (mise à jour du profil)
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'sometimes|nullable|string',
            'avatar_url' => 'sometimes|nullable|url'
        ]);

        $user->update($validated);

        // on s'assure que les données sont refresh
        $user->refresh();

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'bio' => $user->bio,
            'avatar_url' => $user->avatar_url
        ]);
    }
}