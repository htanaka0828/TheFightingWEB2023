<?php
require_once './function.php';

// POSTをされたかどうか
if(
  $_SERVER["REQUEST_METHOD"] == "POST" &&
  $_POST['bbs_id']) {
  deleteBbs($_POST['bbs_id']);
}
header('Location: /bbs.php');
