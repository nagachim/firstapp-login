<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

// ログイン状態チェック
if (!isset($_SESSION['nickname'])) {
    header("Location: logout.php");
    exit;
}

$text = $_SESSION['nickname'];
$text = mb_convert_encoding($text, 'Shift-JIS', 'UTF-8');

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
        <p>ようこそ<u><?php echo htmlspecialchars($text, ENT_QUOTES,'Shift-JIS'); ?></u>さん</p>
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>