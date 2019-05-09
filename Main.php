<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// ログイン状態チェック
if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
    exit;
}
$str = $_SESSION['username'];

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
}else{
	$select = sprintf("SELECT * FROM salesforce.test__c WHERE testname__c = '%s'; ",$str);
	$result = pg_query($select);
	$arr = pg_fetch_array($result);

	$name = $arr[2];
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>メイン</title>
        <link rel= "stylesheet" href="font.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>メイン画面</h1>

        <?php if(empty($result)){  ?>
        <p>ようこそ<u><?php echo htmlspecialchars($name, ENT_QUOTES,utf-8); ?></u>さん</p>
        <!--  }?>  -->
        
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
        <div><?php
        if($str == 'nagachim'){
            echo '<a href="secret1.html">お遊び</a>';
        }?></div>
    </body>
</html>