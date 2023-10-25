<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentsController extends Controller
{
    public function index()
    {
        $coomentAll = Comment::all();
        return view('comments')->with('comments', $coomentAll);
    }
}
