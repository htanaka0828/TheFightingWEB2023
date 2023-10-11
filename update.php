<?php
require_once './function.php';

require_once './classes/Models/CommentsModel.php';

$CommentsModel = new CommentsModel();
$comment = $CommentsModel->findByCol($_GET['bbs_id']);

if($_SESSION['account']['id'] !== $comment['account_id']) {
    header('Location: /bbs.php');
    exit;
}

$result = [
    'name' => true,
    'comment' => true
];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // validation処理
    $result = validationPost($_POST['comment']);
    if($result['comment']) {
        // 更新処理
        $CommentsModel->update($_GET['bbs_id'], ['comment' => $_POST['comment']]);
        header('Location: /bbs.php');
        exit;
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
.logout-wrap {
    text-align: right;
}
</style>
<body>
    <h1>BBS</h1>
    <div>
        <p>これは良い感じのBBSの編集画面です</p>
    </div>

    <?php if($_SESSION['account']): ?>
        <div class="logout-wrap"><a href="/logout.php">ログアウトする！</a></div>
        <form action="/update.php?bbs_id=<?php echo $_GET['bbs_id']; ?>" method="POST">
            <div>
                <label for="name">
                    名前: <input type="text" id="name" name="name" value="<?php echo $_SESSION['account']['name']; ?>" disabled />
                </label>
            </div>
            <div>
                <label for="comment">
                    コメント:<textarea id="comment" name="comment" ><?php echo $comment['comment'] ?></textarea>
                </label>
                <?php if($result['comment'] === false): ?>
                    <p class="error-text">入力は1024文字までです</p>
                <?php endif; ?>
            </div>
            <input type="submit" value="送信">
        </form>
    <?php endif; ?>
</div>
</body>
</html>