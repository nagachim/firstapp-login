<?php
session_start();

if (isset($_SESSION['NAME'])) {
    $errorMessage = "���O�A�E�g���܂����B";
} else {
    $errorMessage = "�Z�b�V�������^�C���A�E�g���܂����B";
}

// �Z�b�V�����̕ϐ��̃N���A
$_SESSION = array();

// �Z�b�V�����N���A
@session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>���O�A�E�g</title>
    </head>
    <body>
        <h1>���O�A�E�g���</h1>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="Login.php">���O�C����ʂɖ߂�</a></li>
        </ul>
    </body>
</html>