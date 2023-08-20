<?php

function openFile() {
    $fileName = './bbs/comment.txt';
    return fopen($fileName, 'a+');
}

function closeFile($fh) {
    fclose($fh);
}

function validationPost($name, $comment) {
    $result = [
        'name' => true,
        'comment' => true
    ];

    // name -> アルファベット(大文字/小文字)と数字のみ / 32文字までに制限 / 3文字以上
    if(preg_match('/[A-Za-z0-9]{3,32}/', $name) !== 1) {
        $result['name'] = false;
    }

    // comment -> 1024文字(2のn乗です) / 許容する文字に制限は設けない
    if(mb_strlen($comment) > 1024) {
        $result['comment'] = false;
    }

    return $result;
}

function requestPost($fh) {
    $date = time();

    if(fputcsv($fh, [$_POST['name'], $_POST['comment'], $date]) === false) {
        // @todo エラーハンドリングをもっとまじめにするよ
        echo "やばいよ！";
    }
}

function getBbs($fh) {
    $bbsArray = [];
    rewind($fh);
    while (($buffer = fgetcsv($fh, 4096)) !== false) {
        $bbsArray[] = [
            'name' => $buffer[0],
            'comment' => $buffer[1],
            'date' => $buffer[2]
        ];
    }
    return $bbsArray;
}
