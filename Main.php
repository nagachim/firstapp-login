<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

// ���O�C����ԃ`�F�b�N
if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
    exit;
}
$str = $_SESSION['username'];
//$str = mb_convert_encoding($str,"utf-8","sjis");

$dbUrl = parse_url(getenv('DATABASE_URL'));
$db['host'] = $dbUrl['host'];
$db['user'] = $dbUrl['user'];
$db['pass'] = $dbUrl['pass'];
$db['dbname'] = ltrim($dbUrl['path'], '/');  // �f�[�^�x�[�X��

//DB�ڑ����쐬
$connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
////DB�ڑ�
//if(!$result = pg_connect($connectString)){
//    //�ڑ����s
//    $errorMessage = '�\�����ʃG���[������';
//    exit();
//}else{
//	//$select = sprintf("SELECT name FROM salesforce.user WHERE communitynickname = '%s'; ",$str);
	$select = "SELECT name FROM salesforce.user WHERE communitynickname = 'nagachimu';";
	$result = pg_query($select,$connectString);
	$array = pg_fetch_array($result, 0, PGSQL_ASSOC);
	$name = $array['name'];
//}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="shift_JIS">
        <title>���C��</title>
        <link rel= "stylesheet" href="font.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>���C�����</h1>
        <p>�悤����<u><?php echo htmlspecialchars($name, ENT_QUOTES,sjis); ?></u>����</p>
        <div><?php
        if(!empty($result)){
        echo '<p>�悤����salesforce <u><?php echo htmlspecialchars($name, ENT_QUOTES,sjis); ?></u>����</p>';
        }?></div>
        
        <ul>
            <li><a href="logout.php">���O�A�E�g</a></li>
        </ul>
        <div><?php
        if($str == 'nagachim'){
            echo '<a href="secret.html">���V��</a>';
        }?></div>
    </body>
</html>