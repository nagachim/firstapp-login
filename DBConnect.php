<?php
//heroku postgresSQLに接続する関数

function db_connect(){

    $url = parse_url(gentenv('DATABASE_URL'));

    $dsn = sprintf('pgsql:host=%s;dbname=%s',$url['host'],substr($url['path'],1));

    $pdo = new PDO($dsn,$url['user'],$url['pass']);
    var_dump($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));
}

?>
