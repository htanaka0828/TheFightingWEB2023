<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body class="antialiased">
        <h1>ログインをするよ</h1>
        <div>
            <form action="/accounts" method="POST">
                @csrf
                <div>
                    name: <input type="text" name="name" />
                </div>
                <div>
                    password: <input type="password" name="password" />
                </div>
                <div>
                    <input type="submit" value="ログイン！" />
                </div>
            </form>
        </div>
    </body>
</html>
