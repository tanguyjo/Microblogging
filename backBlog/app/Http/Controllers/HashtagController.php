<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function index()
    {
        return Hashtag::all();
    }

    public function show(Hashtag $hashtag)
    {
        return $hashtag->load('posts');
    }

    public function posts(Hashtag $hashtag)
    {
        return $hashtag->posts;
    }
}
