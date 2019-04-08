<?php

session_start();

//header('Location: /index.html');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DBサーバのURL
$db['user'] = $dbUrl['user'];  // ユーザー名
$db['pass'] = $dbUrl['pass'];  // ユーザー名のパスワード
$db['dbname'] = ltrim($dbUrl['path'], '/');;  // データベース名


//エラーメッセージの初期化
$errorMessage = "";
$loginerror = "";

// ログインボタンが押された場合
if (isset($_POST['login'])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST['username'])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST['password'])) {
        $errorMessage = 'パスワードが未入力です。';
    }
    
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // 入力したユーザを格納
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        //DB接続情報作成
        $connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
        //DB接続
        if(!$result = pg_connect($connectString)){
            //接続失敗
            $errorMessage = '予期せぬエラーが発生';
            exit();
        }

        $select = sprintf("SELECT * FROM userInfo WHERE username='%s' and password='%s'",$_SESSION['username'],$_SESSION['password']);
        $sqlresult = pg_query($select);
        
        if(!$sqlresult){
            $loginerror = '入力されたユーザ又はパスワードは存在しません';
        }else
        {
            $loginerror = $sqlresult;
        }

        // 2. ユーザとパスワードが入力されていたら認証する
//        $dsn = sprintf('pgsql: host=%s; dbname=%s;', $db['host'], $db['dbname']);
//
//        // 3. エラー処理
//        try {
//            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
//
//            $stmt = $pdo->prepare('SELECT * FROM userInfo WHERE username = ? and password = ?');
//            $stmt->execute(array($username,$password));
//
//
//            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                if (password_verify($password, $row['password'])) {
//                    session_regenerate_id(true);
//
//                    // 入力したユーザー名を取得
//                    $username = $row['username'];
//                    $password = $row['password'];
//                    $sql = "SELECT * FROM userInfo WHERE username = $username and password = $password";
//                    $stmt = $pdo->query($sql);
//                    foreach ($stmt as $row) {
//                        $row['username'];  // ユーザー名
//                    }
//                    $_SESSION['username'] = $row['username'];
//                    header("Location: Main.php");  // メイン画面へ遷移
//                    exit();  // 処理終了
//                } else {
//                    // 認証失敗
//                    $errorMessage = 'ユーザ名あるいはパスワードに誤りがあります。';
//                }
//            } else {
//                // 4. 認証成功なら、セッションIDを新規に発行する
//                // 該当データなし
//                $errorMessage = 'ユーザ名あるいはパスワードに誤りがあります。';
//            }
//        } catch (PDOException $e) {
//            $errorMessage = 'データベースエラー';
//            //$errorMessage = $sql;
//            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
//            // echo $e->getMessage();
//        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ログイン画面</title>
        <link rel= "stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <form id="loginForm" name="loginForm" action="" method="POST" accept-charset="shift_JIS">
            <fieldset>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="username">ユーザ名</label><input type="text" id="username" name="username" placeholder="ユーザ名を入力" value="">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
                <div><font color="#ff0000"><?php echo htmlspecialchars($loginerror, ENT_QUOTES); ?></font></div>
            </fieldset>
    </body>
</html>

