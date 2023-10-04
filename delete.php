<?php
require_once './function.php';

// POSTをされたかどうか
if(
  $_SERVER["REQUEST_METHOD"] == "POST" &&
  $_POST['bbs_id']) {
  $pdo = dbConnect();

  // @todo bbs_idの存在確認

  // 削除処理
  deleteBbs($pdo, $_POST['bbs_id']);
}
header('Location: /bbs.php');
