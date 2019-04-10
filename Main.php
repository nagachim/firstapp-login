<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

$str = $_SESSION['nickname'];
$str = mb_convert_encoding($str, "SJIS", "EUC-JP");

// ���O�C����ԃ`�F�b�N
if (!isset($_SESSION['nickname'])) {
    header("Location: logout.php");
    exit;
}

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
        <p>�悤����<u><?php echo htmlspecialchars($str, ENT_QUOTES); ?></u>����</p>
        <ul>
            <li><a href="logout.php">���O�A�E�g</a></li>
        </ul>
    </body>
</html>