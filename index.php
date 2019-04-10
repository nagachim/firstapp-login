<?php
session_start();

header('Content-Type: text/html; charset=UTF-8');

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
        $errorMessage = 'ユーザ名が未入力です。';
    } else if (empty($_POST['password'])) {
        $errorMessage = 'パスワードが未入力です。';
    }
    
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // 入力したユーザを格納
        $name = $_POST['username'];

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
            $errorMessage = '入力されたユーザ又はパスワードは存在しません';
        }else
        {
            //pg_fetch_array(select文の結果をresultに入れたものを配列に)
            $array = pg_fetch_array($result,0,PGSQL_NUM);
            
            //ログイン成功時に表示するニックネームをセッションに
            $_SESSION['nickname'] = $array[3];
            
            $_SESSION['1'] = $array[0];
            $_SESSION['2'] = $array[1];
            $_SESSION['3'] = $array[2];
            $_SESSION['4'] = $array[3];
            $_SESSION['5'] = $array[4];
            $_SESSION['6'] = $array[5];
            
            
            //ログイン回数カウント
            $cnt = $array[4];
            $cnt = $cnt + 1;
            $_SESSION['logincnt'] = $cnt;
            
            //セッションにユーザ名を保存
            $_SESSION['username'] = $name;
            
            //ログイン回数をアップデート文で更新
            $update = sprintf("UPDATE userInfo SET loginCnt=%d where username='%s'",$cnt,$name);
            $updresult = pg_query($update);
            if(!$updresult){
                $errorMessage = '予期せぬエラーが発生（ＵＰＤＡＴＥ）';
            }
            header("Location: Main.php");
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
        <H1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST" accept-charset="shift_JIS">
            <fieldset>
                <label for="username">ユーザ名　：</label><input type="text" id="username" name="username" placeholder="ユーザ名を入力" value="">
                <br>
                <label for="password">パスワード：</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            </fieldset>
    </body>
</html>

