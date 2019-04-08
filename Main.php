<?php
session_start();

$string = (string)filter_input(INPUT_POST,$_SESSION['NAME']);
if ($string){
    $string = htmlspecialchar($string, ENT_QUOTES,'SJIS-win');
} else {
    $string = 'no data.';
}


// ���O�C����ԃ`�F�b�N
if (!isset($_SESSION['NAME'])) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="shift_JIS">
        <title>���C��</title>
        <link rel= "stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <h1>���C�����</h1>
        <!-- ���[�U�[ID��HTML�^�O���܂܂�Ă��ǂ��悤�ɃG�X�P�[�v���� -->
        <p>�悤����<u><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></u>����</p>  <!-- ���[�U�[����echo�ŕ\�� -->
        <ul>
            <li><a href="logout.php">���O�A�E�g</a></li>
        </ul>
    </body>
</html>