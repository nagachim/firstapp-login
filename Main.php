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
	$bikou = $arr[9];
	$sex = $arr[10];
	$add = $arr[11];
	$age = $arr[12];
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>メイン</title>
        <link rel= "stylesheet" href="style.css">
    </head>
    <body>
        <h1>メイン画面</h1>

        <p>ようこそ<u> salesforce会員 <?php echo htmlspecialchars($name, ENT_QUOTES,utf-8); ?></u>さん</p>
        
        <label for="Age">年齢：</label><input type="text" id="age" name="age" value="<?php echo htmlspecialchars($age, ENT_QUOTES,utf-8); ?>">
        <br>
        <label for="Sex">性別：</label><input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($sex, ENT_QUOTES,utf-8); ?>">
        <br>
        <label for="Add">住所：</label><input type="text" id="add" name="add" value="<?php echo htmlspecialchars($add, ENT_QUOTES,utf-8); ?>">
        <br>
        <br>
        <label for="Bikou">備考：</label><textarea name="bikou" rows="4" cols="22"><?php echo htmlspecialchars($bikou, ENT_QUOTES,utf-8); ?></textarea>
        <br>
        <br>
        <input type="submit" id="update" name="update" value="更新">
        <br>
        <a href="logout.php">ログアウト</a>
        
    </body>
</html>