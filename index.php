<?php

session_start();

header('Location: /index.html');

//エラーメッセージの初期化
$errorMessage = "";

//ログインボタン押下処理
if(empty($_POST["login_Button"])){
    if(empty($_POST["username"])){
        $errorMessage = "ユーザ名が未入力です";
    }else if(empty($_POST["password"])){
        $errorMessage = "パスワードが未入力です";
    }
    //ユーザ名もパスも入力されていたら
    if(!empty($_POST["username"] && !empty($_POST["password"])){
        //postgresSQLに接続
        
    }
}

?>
