<?php
session_start();
require_once './function.php';

// POSTをされたかどうか
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // @todo validation check

  // acccount情報とPOSTの情報が一致するかどうか
  $result = checkLogin($_POST['id'], $_POST['password']);

  if($result) {
    // 一致した場合には、ログイン状態にする
    $_SESSION['login'] = $_POST['id'];
  }
  // @todo login処理が終わった後リダイレクトをしたいです

} else {
  // @todo ここどうする？
}
