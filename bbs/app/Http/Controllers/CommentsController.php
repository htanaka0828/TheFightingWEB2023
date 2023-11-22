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

        $account = isset($_SESSION['account']) ? $_SESSION['account'] : null;

        return view('comments')
            ->with('comments', $coomentAll)
            ->with('account', $account);
    }

    public function create(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        // コメント作成処理
        $comment = new Comment();
        $comment->account_id = $_SESSION['account']->id;
        $comment->comment = $request->input('comment');
        $comment->save();

        // コメント一覧ページにリダイレクトする
        return redirect('/comments');
    }
}
