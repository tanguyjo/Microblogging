<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}

