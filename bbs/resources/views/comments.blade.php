<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <style>
            .comment {
                background-color: beige;
                margin: 12px;
                border-radius: 5px;
                padding: 12px;
            }
        </style>
    </head>
    <body class="antialiased">
        <h1>良い感じのBBSだよ</h1>
        <!-- ログインしている場合のみ入力formを出す -->
        @if ($account)
            <div>
                <h2>ログアウトする？</h2>
                <form action="/accounts/logout" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-success"> 送信 </button>
                </form>
            </div>

            <div>
                <h2>コメントを入れてね</h2>
                <form action="/comments" method="POST">
                    名前:<br>
                    {{ $account->name }}
                    <br>
                    コメント:<br>
                    <textarea name="comment" rows="4" cols="40"></textarea>
                    <br>
                    {{ csrf_field() }}
                    <button class="btn btn-success"> 送信 </button>
                </form>
            </div>
        @else
        <a href="/accounts">ログインページへ</a>
        @endif
        <div>
            <h2>コメント一覧</h2>
            @foreach ($comments as $comment)
                <div class="comment">
                    <p>id: {{ $comment->comment_id }}</p>
                    <p>name: {{ $comment->name }}</p>
                    <p>comment: {!! nl2br(e($comment->comment)) !!}</p>
                    <p>created date: {{ $comment->create_date }}</p>
                    @if ($account && $account->admin_flag == 1)
                        <form action="/comments/delete" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="comment_id" value="{{$comment->comment_id}}">
                            <button class="btn btn-success"> 送信 </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </body>
</html>
