<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// ���O�C����ԃ`�F�b�N
//if (!isset($_SESSION['username'])) {
if (!isset($string)) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="content-type" charset="utf-8">
        <title>���C��</title>
        <link rel= "stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>���C�����</h1>
        <p>�悤����<u><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></u>����</p>
        <ul>
            <li><a href="logout.php">���O�A�E�g</a></li>
        </ul>
    </body>
</html>