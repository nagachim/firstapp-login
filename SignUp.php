<?php
// セッション開始
session_start();

header('Content-Type: text/html; charset=utf-8');

$dbUrl = parse_url($_SERVER['CLEARDB_DATABASE_URL']);

$db['dbname'] = ltrim($dbUrl['path'], '/');  // データベース名
$dsn = "mysql:host={$dbUrl['host']};dbname={$db['dbname']};charset=utf8";


$db['user'] = $dbUrl['user'];  // ユーザー名
$db['pass'] = $dbUrl['pass'];  // ユーザー名のパスワード

//接続の際のオプション
$options = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
);

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";
$name = "";
$pass = "";
$nickname = "";

// 新規登録ボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST['username'])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST['password'])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST['password2'])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST['nickname'])){
        $errorMessage = 'ニックネームが未入力です';
    }

    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password2']) && $_POST['password'] === $_POST['password2']) {
        // 入力したユーザIDとパスワードを格納
        $name = $_POST['username'];
        $pass = $_POST['password'];
        $nickname = $_POST['nickname'];

/////////////////////////////////////////////////////////////Postgres
        //DB接続情報作成
//        $connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
        //DB接続
//        if(!$result = pg_connect($connectString)){
            //接続失敗
//            $errorMessage = '予期せぬエラーが発生（管理者問い合わせ）';
//            exit();
//        }
//        $select = sprintf("SELECT username FROM userInfo WHERE username='%s'",$name);
//        $selectresult = pg_query($select);
//        $array = pg_fetch_array($selectresult,0,PGSQL_NUM);
/////////////////////////////////////////////////////////////

		//mysql接続処理
		$mysqli = new mysqli($dbUrl['host'],$db['user'],$db['pass'],$db['dbname']);
		if($mysqli->connect_error){
			echo $mysqli->connect_error;
			exit();
		}else{
			$mysqli->set_charset("utf8");
		}
		
		
		//SELECT文 ステートメント
		$select = sprintf("SELECT username FROM heroku_f900e31a135809c.userinfo WHERE username='%s'",$name);
		$result = $mysqli->query($select);
		
		$array = $result->fetch_array(MYSQLI_ASSOC);

        //DB検索結果で入力した名前が存在した場合
        //新たに登録できないようにエラーメッセージではじく
        if($name == $array[0]){
            $errorMessage='既に使用されているユーザ名です'; 
        }else{
//////////////////////////////////////////////////////////////////////
            //ユーザ情報登録処理
            $insert = sprintf("INSERT INTO userInfo( username, password, nickname, logincnt, systimestamp) VALUES ( '%s', '%s', '%s', 0, current_timestamp)",$name,$pass,$nickname);
            $insertresult = pg_query($insert);
            if(!$insertresult){
                $errorMessage = '予期せぬエラーが発生（ＩＮＳＥＲＴ）';
            }
            
            //DB切断
            pg_close($result);
//////////////////////////////////////////////////////////////////////
			$insert = sprintf("INSERT INTO heroku_f900e31a135809c.userinfo( username, password, nickname, logincnt, systimestamp) VALUES ( '%s', '%s', '%s', 0, current_timestamp)",$name,$pass,$nickname);

            
            //登録成功画面へ
            header("Location: RegSuccess.php");
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードが確認用と一致しません。';
    }
//////////////////////////
    //DB切断
//    pg_close($result);
//////////////////////////
	$mysqli->close();
    
}
?>
<!doctype html>
<html>
    <head>
            <meta charset="utf-8">
            <title>新規登録</title>
            <link rel= "stylesheet" href="style.css">
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="SignUpForm" name="SignUpForm" action="" method="POST">
            <fieldset>
                <legend>新規登録者フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="username">ユーザー名　　　　　　：</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="">
                <br>
                <label for="password">パスワード　　　　　　：</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード（確認用）　：</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <label for="nickname">ニックネーム　　　　　：</label><input type="text" id="nickname" name="nickname" value="" placeholder="ニックネームを入力">
                <br>
                <input type="submit" id="signUp" name="signUp" value="登録">
            </fieldset>
        </form>
        <br>
        <form action="index.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>