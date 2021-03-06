<?php
session_start();

header('Content-Type: text/html; charset=UTF-8');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DBサーバのURL
$db['user'] = $dbUrl['user'];  // ユーザー名
$db['pass'] = $dbUrl['pass'];  // ユーザー名のパスワード
$db['dbname'] = ltrim($dbUrl['path'], '/');  // データベース名


//エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST['login'])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST['username'])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザ名が未入力です。';
    } else if (empty($_POST['password'])) {
        $errorMessage = 'パスワードが未入力です。';
    }
    
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // 入力したユーザを格納
        $name = $_POST['username'];
        $pass = $_POST['password'];

        //DB接続情報作成
        $connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
        //DB接続
        if(!$result = pg_connect($connectString)){
            //接続失敗
            $errorMessage = '予期せぬエラーが発生';
            exit();
        }

        $select = sprintf("SELECT * FROM userInfo WHERE username='%s' and password='%s'",$name,$pass);
        $selectresult = pg_query($select);
        $array = pg_fetch_array($selectresult,0,PGSQL_NUM);
        
        
        if(!$name = $array[1]){
            $errorMessage = '入力されたユーザ又はパスワードは存在しません';
        }else
        {
            //pg_fetch_array(select文の結果をresultに入れたものを配列に)
            
            
            //ログイン成功時に表示するニックネームをセッションに
            //$_SESSION['nickname'] = $array[3];
            $_SESSION['username'] = $name;
            
            //ログイン回数カウント
            $cnt = $array[4];
            $cnt = $cnt + 1;
            
            //ログイン回数をアップデート文で更新
            $update = sprintf("UPDATE userInfo SET loginCnt=%d where username='%s'",$cnt,$name);
            $updresult = pg_query($update);
            if(!$updresult){
                $errorMessage = '予期せぬエラーが発生（ＵＰＤＡＴＥ）';
            }
            //DB切断
            pg_close($result);
            header("Location: Main.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ログイン画面</title>
        <link rel= "stylesheet" href="style.css">
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST" accept-charset="UTF-8">
            <fieldset>
                <legend>ログイン情報</legend>
                <label for="username">ユーザ名　：</label><input type="text" id="username" name="username" placeholder="ユーザ名を入力" value="">
                <br>
                <label for="password">パスワード：</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            </fieldset>
        </form>
        <br>
        <a href="SignUp.php">新規登録はこちら</a>
    </body>
</html>

