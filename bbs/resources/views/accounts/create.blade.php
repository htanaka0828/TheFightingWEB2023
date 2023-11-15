<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body class="antialiased">
        <h1>アカウントを作成するよ</h1>
        <div>
            <form action="/accounts/create" method="POST">
                @csrf
                <div>
                    name: <input type="text" name="name" />
                </div>
                <div>
                    password: <input type="password" name="password" />
                </div>
                <div>
                    isAdmin: <input type="checkbox" name="admin_flag" value="1" />
                </div>
                <div>
                    <input type="submit" value="送信！" />
                </div>
            </form>
        </div>
    </body>
</html>
