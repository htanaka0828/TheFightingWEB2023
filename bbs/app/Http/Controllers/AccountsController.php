<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Account;


class AccountsController extends Controller
{
    public function index()
    {
        return view('accounts.index');
    }

    public function login(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');

        // バリデーション
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        // nameを使ってaccountsテーブルから対象のデータを取得する
        $AccountModel = new Account();
        $account = $AccountModel->where('name', $name)->first();

        // passwordを使って、入力されたパスワードが正しいかチェックする
        if (empty($account) || !Hash::check($password, $account->password)) {
            // ログイン失敗したら、ログインページにリダイレクトする
            return redirect('/accounts');
        }

        // ログイン処理(SESSIONにログイン情報を保存する)
        $_SESSION['account'] = $account;

        // ログイン成功したら、コメント一覧ページにリダイレクトする
        return redirect('/comments');
    }

    public function logout()
    {
        // ログアウト処理(SESSIONに保存しているログイン情報を削除する)
        unset($_SESSION['account']);

        // ログアウト成功したら、コメント一覧ページにリダイレクトする
        return redirect('/comments');
    }

    public function create_form()
    {
        return view('accounts.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'admin_flag' => 'integer | between:0,1'
        ]);

        // アカウント作成処理
        $admin_flag = $request->input('admin_flag');

        $AccountModel = new Account();
        $AccountModel->name = $request->input('name');
        $AccountModel->password = Hash::make($request->input('password'));
        $AccountModel->admin_flag = empty($admin_flag) ? 0 : $admin_flag;
        $AccountModel->save();

        // アカウント作成成功したら、ログインページにリダイレクトする
        return redirect('/accounts');
    }
}
