<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

// ログイン状態チェック
if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
    exit;
}
$str = $_SESSION['username'];
//$str = mb_convert_encoding($str,"utf-8","sjis");

$dbUrl = parse_url(getenv('DATABASE_URL'));
$db['host'] = $dbUrl['host'];
$db['user'] = $dbUrl['user'];
$db['pass'] = $dbUrl['pass'];
$db['dbname'] = ltrim($dbUrl['path'], '/');  // データベース名

//DB接続情報作成
$connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
//DB接続
if(!$result = pg_connect($connectString)){
    //接続失敗
    $errorMessage = '予期せぬエラーが発生';
    exit();
}

$select = sprintf("SELECT name FROM salesforce.user WHERE communitynickname = '%s'; ",$str);
$result = pg_query($select);
//$array = pg_fetch_array($result ,0 ,PGSQL_NUM);
$errorMessage = $result;
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
        <p>ようこそ<u><?php echo htmlspecialchars($str, ENT_QUOTES); ?></u>さん</p>
        <div><?php
        if(!empty($result)){
        echo '<p>ようこそsalesforce <u><?php echo htmlspecialchars($result, ENT_QUOTES); ?></u>さん</p>';
        }?></div>
        
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
        <div><?php
        if($str == 'nagachim'){
            echo '<a href="secret.html">お遊び</a>';
        }?></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
    </body>
</html>