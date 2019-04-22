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

$dbUrl = puarse_url(getenv('DATABASE_URL'));
$db['host'] = $dbUrl['host'];
$db['user'] = $dbUrl['user'];
$db['pass'] = $dbUrl['pass'];
$db['dbname'] = 'salesforce';

$select = sprintf("SELECT name FROM salesforce.user WHERE communitynickname = '%s' ",$str);
$result = pg_query($select);
$array = pg_fetch_array($result ,0 ,PGSQL_NUM);

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
        <p>ようこそ<u><?php echo htmlspecialchars($str, ENT_QUOTES,sjis); ?></u>さん</p>
        <?php
        if(!empty($array[0])){
        echo '<p>ようこそsalesforce <u><?php echo htmlspecialchars($array[0], ENT_QUOTES,sjis); ?></u>さん</p>';
        }?>
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
        <div><?php
        if($str == 'nagachim'){
            echo '<a href="secret.html">お遊び</a>';
        }?></div>
    </body>
</html>