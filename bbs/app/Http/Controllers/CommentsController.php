<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentsController extends Controller
{
    public function index()
    {
        $coomentAll = Comment::query()
            ->join('accounts', 'account_id', '=', 'accounts.id')
            ->select('name', 'comment', 'comments.created_at as create_date')
            ->get();
        return view('comments')->with('comments', $coomentAll);
    }
}
