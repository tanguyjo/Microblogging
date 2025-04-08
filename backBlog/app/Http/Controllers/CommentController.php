<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with(['user', 'post'])->get();
    }

    public function show($id)
    {
        return Comment::with(['user', 'post'])->findOrFail($id);
    }
}
