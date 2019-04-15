<?php
// セッション開始
session_start();

header('Content-Type: text/html; charset=utf-8');
?>

<!doctype html>
<html>
    <head>
            <meta charset="utf-8">
            <title>新規登録完了画面</title>
    </head>
    <body>
        <h1>登録完了</h1>
        <form id="regSuccessForm" name="regSuccessForm" action="" method="POST">
            <fieldset>
                <legend>新規登録者完了</legend>
                <p>ユーザの新規登録が完了いたしました。</p>
            </fieldset>
        </form>
        <br>
        <form action="index.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>