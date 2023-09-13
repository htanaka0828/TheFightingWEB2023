<?php
require_once './function.php';

// POSTをされたかどうか
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // @todo validation check

  // acccount情報とPOSTの情報が一致するかどうか
  $result = checkLogin($_POST['id'], $_POST['password']);

  if($result) {
    $account = findAccount($_POST['id']);
    // 一致した場合には、ログイン状態にする
    $_SESSION['login'] = $account['id'];
    $_SESSION['isAdmin'] = ($account['isAdmin'] == 1);
  }
}
header('Location: /bbs.php');
