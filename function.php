<?php

define('COMMENT_FILE', './bbs/comment.txt');
define('ACCOUNT_FILE', './bbs/account.csv');
session_start();

function checkLogin($id, $password) {

    // account.csvを開く
    $fh = openFile(ACCOUNT_FILE);

    // fileの中身を全て取得して配列にする
    $accounts = getAccounts($fh);
    closeFile($fh);

    return existsAccount($accounts, $id, $password);
}

function existsAccount($accounts, $id, $password) {
    // 配列データをloopして、一致する情報があるかを判定する
    foreach($accounts as $account) {
        if($account['id'] === $id && $account['pass'] === $password) {
            return true;
        }
    }

    // 失敗ならfalse
    return false;
}

function openFile($fileName) {
    if(!file_exists($fileName)) {
        touch($fileName);
        chmod($fileName, 0777);
    }
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

function getAccounts($fh) {
    $accountArray = [];
    rewind($fh);
    while (($buffer = fgetcsv($fh, 4096)) !== false) {
        $accountArray[] = [
            'id' => $buffer[0],
            'pass' => $buffer[1]
        ];
    }
    return $accountArray;
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
