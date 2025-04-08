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

    public function show($id)
    {
        return Hashtag::with('posts')->findOrFail($id);
    }

    public function posts($id)
    {
        $hashtag = Hashtag::findOrFail($id);
        return $hashtag->posts;
    }
}
