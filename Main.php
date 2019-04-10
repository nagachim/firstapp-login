<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// ���O�C����ԃ`�F�b�N
if (!isset($_SESSION['nickname'])) {
    header("Location: logout.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>���C��</title>
        <link rel= "stylesheet" href="font.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>���C�����</h1>
        <p>�悤����<u><?php echo htmlspecialchars($_SESSION['nickname'], ENT_QUOTES); ?></u>����</p>
        <ul>
            <li><a href="logout.php">���O�A�E�g</a></li>
        </ul>
    </body>
</html>