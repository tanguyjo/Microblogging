<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['user', 'hashtags', 'comments'])->get();
    }

    public function show($id)
    {
        return Post::with(['user', 'hashtags', 'comments'])->findOrFail($id);
    }

    public function hashtags($id)
    {
        $post = Post::findOrFail($id);
        return $post->hashtags;
    }
}
