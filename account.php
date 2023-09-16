<?php
require_once './function.php';
$result = [
    'name' => true
];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = dbConnect();
    // validation処理
    $result['name'] = checkDeplicateAccount($pdo, $_POST['name']);
    if($result['name']) {
        // 保存処理
        saveAccount($pdo, $_POST['name'], $_POST['password'], !empty($_POST['is_admin']));
        header('Location: /bbs.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formサンプル</title>
</head>
<style>
.error-text {
    color: red;
}
</style>
<body>
    <h1>BBS - account作製</h1>
    <div>
        <p>idとpasswordを入れてね～</p>
    </div>
    <form action="/account.php" method="POST">
        <div>
            <label for="name">
                ID: <input type="text" id="name" name="name" value="" />
            </label>
            <?php if($result['id'] === false): ?>
                <p class="error-text">重複したidが既に存在しています</p>
            <?php endif; ?>
        </div>
        <div>
            <label for="password">
                Password: <input type="password" id="password" name="password" value="" />
            </label>
        </div>
        <div>
            <label for="is_admin">
                isAdmin: <input type="checkbox" id="is_admin" name="is_admin" />
            </label>
        </div>
        <input type="submit" value="作成！">
    </form>
</div>
</body>
</html>