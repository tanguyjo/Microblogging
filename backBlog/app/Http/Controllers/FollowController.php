<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function followers($userId)
    {
        $user = User::findOrFail($userId);
        return $user->followers;
    }

    public function following($userId)
    {
        $user = User::findOrFail($userId);
        return $user->following;
    }
}
