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
        @foreach ($comments as $comment)
            <div class="comment">
                <p>name: {{ $comment->name }}</p>
                <p>comment: {{ $comment->comment }}</p>
                <p>created date: {{ $comment->create_date }}</p>
            </div>
        @endforeach
    </body>
</html>
