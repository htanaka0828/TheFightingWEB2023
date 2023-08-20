<?php
require_once './function.php';

// セッション変数を全て解除する
$_SESSION = array();

// @todo sessionのcookieを削除する

header('Location: /bbs.php');
