<?php
//     // ここで取得したデータを処理するか表示する処理を行う
// }
// 都道府県名とPrefCodeの対応リスト
$prefectures = array(
  '北海道' => 1,
  '青森県' => 2,
  '岩手県' => 3,
  '宮城県' => 4,
  '秋田県' => 5,
  '山形県' => 6,
  '福島県' => 7,
  '茨城県' => 8,
  '栃木県' => 9,
  '群馬県' => 10,
  '埼玉県' => 11,
  '千葉県' => 12,
  '東京都' => 13,
  '神奈川県' => 14,
  '新潟県' => 15,
  '富山県' => 16,
  '石川県' => 17,
  '福井県' => 18,
  '山梨県' => 19,
  '長野県' => 20,
  '岐阜県' => 21,
  '静岡県' => 22,
  '愛知県' => 23,
  '三重県' => 24,
  '滋賀県' => 25,
  '京都府' => 26,
  '大阪府' => 27,
  '兵庫県' => 28,
  '奈良県' => 29,
  '和歌山県' => 30,
  '鳥取県' => 31,
  '島根県' => 32,
  '岡山県' => 33,
  '広島県' => 34,
  '山口県' => 35,
  '徳島県' => 36,
  '香川県' => 37,
  '愛媛県' => 38,
  '高知県' => 39,
  '福岡県' => 40,
  '佐賀県' => 41,
  '長崎県' => 42,
  '熊本県' => 43,
  '大分県' => 44,
  '宮崎県' => 45,
  '鹿児島県' => 46,
  '沖縄県' => 47
);
// フォームが送信されたときに、選択された都道府県を取得
$selectedPrefecture = isset($_POST['prefecture']) ? $_POST['prefecture'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formサンプル</title>
</head>
<body>
    <h1>Formサンプル</h1>
    <form action="" method="post">
        <!-- テキスト入力欄 -->
        <label for="text_input">テキスト入力：</label>
        <input type="text" id="text_input" name="text_input" placeholder="ここにテキストを入力してください" required value="<?php echo isset($_POST['text_input']) ? htmlspecialchars($_POST['text_input']) : ''; ?>"><br>
        <!-- 数字入力欄 -->
        <label for="number_input">数字入力：</label>
        <input type="number" id="number_input" name="number_input" min="0" max="100" required value="<?php echo isset($_POST['number_input']) ? htmlspecialchars($_POST['number_input']) : ''; ?>"><br>
        <!-- 複数行入力欄 -->
        <label for="textarea_input">複数行入力：</label><br>
        <textarea id="textarea_input" name="textarea_input" rows="4" cols="50" placeholder="ここに複数行のテキストを入力してください" required><?php echo isset($_POST['textarea_input']) ? htmlspecialchars($_POST['textarea_input']) : ''; ?></textarea><br>
        <!-- ラジオボタン -->
        <p>性別：</p>
        <label for="male">男</label>
        <input type="radio" id="male" name="gender" value="男" required <?php echo (isset($_POST['gender']) && $_POST['gender'] === '男') ? 'checked' : ''; ?>>
        <label for="female">女</label>
        <input type="radio" id="female" name="gender" value="女" required <?php echo (isset($_POST['gender']) && $_POST['gender'] === '女') ? 'checked' : ''; ?>>
        <label for="other">答えたくない</label>
        <input type="radio" id="other" name="gender" value="答えたくない" required <?php echo (isset($_POST['gender']) && $_POST['gender'] === '答えたくない') ? 'checked' : ''; ?>><br>
        <!-- セレクトボックス -->
        <label for="prefecture">都道府県：</label>
        <select id="prefecture" name="prefecture" required>
            <option value="" disabled selected>選択してください</option>
            <?php
            // 都道府県リストをループしてセレクトボックスのオプションを生成
            foreach ($prefectures as $prefectureName => $prefCode) {
                $selected = ($selectedPrefecture === $prefCode) ? 'selected' : '';
                echo "<option value=\"$prefCode\" $selected>$prefectureName</option>";
            }
            ?>
        </select><br>
        <!-- 送信ボタン -->
        <input type="submit" value="送信">
    </form>
</body>
</html>