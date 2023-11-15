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
        // $email = $request->input('email');
        // $password = $request->input('password');

        // ログイン処理
        // ログイン成功したら、コメント一覧ページにリダイレクトする
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
