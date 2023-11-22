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
            ->select('comments.id as comment_id', 'name', 'comment', 'comments.created_at as create_date')
            ->get();

        $account = $this->getLoginAccount();

        return view('comments')
            ->with('comments', $coomentAll)
            ->with('account', $account);
    }

    public function create(Request $request)
    {
        if(!$this->isLogin()) {
            return redirect('/comments');
        }

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

    public function delete(Request $request)
    {
        $account = $this->getLoginAccount();
        if($account == null || $account->admin_flag != 1) {
            return redirect('/comments');
        }

        $request->validate([
            'comment_id' => 'required'
        ]);

        // コメント削除処理
        $comment = Comment::find($request->input('comment_id'));
        if($comment) {
            $comment->delete();
        }

        // コメント一覧ページにリダイレクトする
        return redirect('/comments');
    }

    private function getLoginAccount()
    {
        return isset($_SESSION['account']) ? $_SESSION['account'] : null;
    }

    private function isLogin()
    {
        return $this->getLoginAccount() != null;
    }
}
