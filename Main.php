<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

$string = (string)filter_input(INPUT_POST,$_SESSION['username']);
if ($string){
    $string = htmlspecialchar($string, ENT_QUOTES,'SJIS-win');
} else {
    $string = 'no data.';
}


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
        <meta charset="shift_JIS">
        <title>メイン</title>
        <link rel= "stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>メイン画面</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
<!--        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></u>さん</p>   -->
            <p>ようこそ<u><?php echo htmlspecialchars($string, ENT_QUOTES); ?></u>さん</p>
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>