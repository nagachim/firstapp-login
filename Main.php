<?php
session_start();
header('Content-Type: text/html; charset=shift_JIS');

// ���O�C����ԃ`�F�b�N
if (!isset($_SESSION['username'])) {
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
        <p>�悤����<u><?php echo htmlspecialchars($_SESSION['nickname'], ENT_QUOTES); ?></u>����</p>
        <p><u><?php echo htmlspecialchars($_SESSION['0'], ENT_QUOTES); ?></u></p>
        <p><u><?php echo htmlspecialchars($_SESSION['1'], ENT_QUOTES); ?></u></p>
        <p><u><?php echo htmlspecialchars($_SESSION['2'], ENT_QUOTES); ?></u></p>
        <p><u><?php echo htmlspecialchars($_SESSION['3'], ENT_QUOTES); ?></u></p>
        <p><u><?php echo htmlspecialchars($_SESSION['4'], ENT_QUOTES); ?></u></p>
        <p><u><?php echo htmlspecialchars($_SESSION['5'], ENT_QUOTES); ?></u></p>
        <ul>
            <li><a href="logout.php">���O�A�E�g</a></li>
        </ul>
    </body>
</html>