<?php
define('COMMENT_FILE', './bbs/comment.txt');
define('BBS_ID_FILE', './bbs/bbd_id.txt');
session_start();

function checkLogin($pdo, $id, $password) {
    $account = findAccountByName($pdo, $id);
    return !empty($account) && password_verify($password, $account['password']) ? $account : false;
}

function findAccountByName($pdo, $id) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$id]);
    return $sth->fetch();
}

function checkDeplicateAccount($pdo, $name) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$name]);
    $result = $sth->fetchAll();
    return count($result) === 0;
}

function existsAccount($accounts, $id, $password) {
    // 配列データをloopして、一致する情報があるかを判定する
    foreach($accounts as $account) {
        if($account['id'] === $id && password_verify($password, $account['pass'])) {
            return true;
        }
    }

    // 失敗ならfalse
    return false;
}

function saveAccount($pdo, $name, $password, $isAdmin) {
    $sth = $pdo->prepare("INSERT INTO `accounts` (`name`, `password`, admin_flag) VALUE(?, ?, ?)");
    return $sth->execute([$name, password_hash($password, PASSWORD_BCRYPT), $isAdmin ? 1 : 0]);
}

function openFile($fileName, $mode = 'a+') {
    if(!file_exists($fileName)) {
        touch($fileName);
        chmod($fileName, 0777);
    }
    return fopen($fileName, $mode);
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

    if(fputcsv($fh, [getBbsNextId(), $_POST['name'], $_POST['comment'], $date]) === false) {
        // @todo エラーハンドリングをもっとまじめにするよ
        echo "やばいよ！";
    } else {
        setLastId();
    }
}

function getAccounts($fh) {
    $accountArray = [];
    rewind($fh);
    while (($buffer = fgetcsv($fh, 4096)) !== false) {
        $accountArray[] = [
            'id' => $buffer[0],
            'pass' => $buffer[1],
            'isAdmin' => $buffer[2]
        ];
    }
    return $accountArray;
}

function getBbs($fh) {
    $bbsArray = [];
    rewind($fh);
    while (($buffer = fgetcsv($fh, 4096)) !== false) {
        $bbsArray[] = [
            'id' => $buffer[0],
            'name' => $buffer[1],
            'comment' => $buffer[2],
            'date' => $buffer[3]
        ];
    }
    return $bbsArray;
}

function deleteBbs($id) {
    $fh = openFile(COMMENT_FILE);
    $bbs = getBbs($fh);
    closeFile($fh);

    $fh = openFile(COMMENT_FILE, 'w');
    foreach($bbs as $record) {
        if($record['id'] != $id) {
            if(fputcsv($fh, [$record['id'], $record['name'], $record['comment'], $record['date']]) === false) {
                // @todo エラーハンドリングをもっとまじめにするよ
                echo "やばいよ！";
            }
        }
    }
    closeFile($fh);
}

function getBbsLastId() {
        // account.csvを開く
        $fh = openFile(BBS_ID_FILE);

        // fileの中身を全て取得して配列にする
        $id = fgets($fh);
        closeFile($fh);

        return (int)$id;
}

function getBbsNextId() {
    $id = getBbsLastId();
    return $id + 1;
}

function setLastId() {
    $id = getBbsNextId();

    $fh = openFile(BBS_ID_FILE, 'w');
    fwrite($fh, $id);
    closeFile($fh);
}

function dbConnect() {
    $pdo = new PDO("mysql:host=mysql;dbname=bbs", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}