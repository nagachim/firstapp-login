<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

// ログイン状態チェック
if (!isset($_SESSION['nickname'])) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="shift_JIS">
        <title>メイン</title>
        <link rel= "stylesheet" href="font.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>メイン画面</h1>
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION['nickname'], ENT_QUOTES,'shift_JIS'); ?></u>さん</p>
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>