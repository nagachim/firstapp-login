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
    }

}

?>
