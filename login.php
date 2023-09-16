<?php
require_once './function.php';

// POSTをされたかどうか
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $pdo = dbConnect();
  // @todo validation check

  // acccount情報とPOSTの情報が一致するかどうか
  $account = checkLogin($pdo, $_POST['name'], $_POST['password']);

  if($account) {
    // 一致した場合には、ログイン状態にする
    $_SESSION['account'] = $account;
  }
}
header('Location: /bbs.php');
