<?php

session_start();

header('Location: /index.html');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DBサーバのURL
$db['user'] = $dbUrl['user'];  // ユーザー名
$db['pass'] = $dbUrl['pass'];  // ユーザー名のパスワード
$db['dbname'] = ltrim($dbUrl['path'], '/');;  // データベース名


//エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST['login'])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST['username'])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST['password'])) {
        $errorMessage = 'パスワードが未入力です。';
    }
    
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // 入力したユーザIDを格納
        $username = $_POST['username'];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('pgsql: host=%s; dbname=%s;', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM userInfo WHERE username = ? and password = ?');
            $stmt->execute(array($username,$password));

            $password = $_POST['password'];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $username = $row['username'];
                    $password = $row['password'];
                    $sql = "SELECT * FROM userInfo WHERE username = $username and password = $password";
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['username'];  // ユーザー名
                    }
                    $_SESSION['username'] = $row['username'];
                    header("Location: Main.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザ名あるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザ名あるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>
