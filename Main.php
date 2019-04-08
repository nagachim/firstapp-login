<?php
session_start();

$string = (string)filter_input(INPUT_POST,$_SESSION['NAME']);
if ($string){
    $string = htmlspecialchar($string, ENT_QUOTES,'SJIS-win');
} else {
    $string = 'no data.';
}


// ログイン状態チェック
if (!isset($_SESSION['NAME'])) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="shift_JIS">
        <title>メイン</title>
        <link rel= "stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>メイン画面</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>