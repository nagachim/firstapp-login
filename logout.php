<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

if (isset($_SESSION['username'])) {
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html lang="ja">
    <head>
        <meta charset="shift_JIS">
        <title>ログアウト</title>
    </head>
    <body>
        <h1>ログアウト画面</h1>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="index.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</html>