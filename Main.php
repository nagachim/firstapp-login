<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// ログイン状態チェック
//if (!isset($_SESSION['username'])) {
if (!isset($string)) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="content-type" charset="utf-8">
        <title>メイン</title>
        <link rel= "stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>メイン画面</h1>
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></u>さん</p>
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>