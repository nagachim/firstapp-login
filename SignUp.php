<?php
// �Z�b�V�����J�n
session_start();

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DB�T�[�o��URL
$db['user'] = $dbUrl['user'];  // ���[�U�[��
$db['pass'] = $dbUrl['pass'];  // ���[�U�[���̃p�X���[�h
$db['dbname'] = ltrim($dbUrl['path'], '/');;  // �f�[�^�x�[�X��

// �G���[���b�Z�[�W�A�o�^�������b�Z�[�W�̏�����
$errorMessage = "";
$signUpMessage = "";

// ���O�C���{�^���������ꂽ�ꍇ
if (isset($_POST["signUp"])) {
    // 1. ���[�UID�̓��̓`�F�b�N
    if (empty($_POST["username"])) {  // �l����̂Ƃ�
        $errorMessage = '���[�U�[ID�������͂ł��B';
    } else if (empty($_POST["password"])) {
        $errorMessage = '�p�X���[�h�������͂ł��B';
    } else if (empty($_POST["password2"])) {
        $errorMessage = '�p�X���[�h�������͂ł��B';
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // ���͂������[�UID�ƃp�X���[�h���i�[
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ���[�UID�ƃp�X���[�h�����͂���Ă�����F�؂���
        $dsn = sprintf('pgsql: host=%s; dbname=%s;', $db['host'], $db['dbname']);

        // 3. �G���[����
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO userinfo(username, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // �p�X���[�h�̃n�b�V�������s���i����͕�����݂̂Ȃ̂�bindValue(�ϐ��̓��e���ς��Ȃ�)���g�p�����A����excute�ɓn���Ă����Ȃ��j
            $userid = $pdo->lastinsertid();  // �o�^����(DB����auto_increment����)ID��$userid�ɓ����

            $signUpMessage = '�o�^���������܂����B���Ȃ��̃��[�U���� '. $username. ' �ł��B�p�X���[�h�� '. $password. ' �ł��B';  // ���O�C�����Ɏg�p����ID�ƃp�X���[�h
        } catch (PDOException $e) {
            $errorMessage = '�f�[�^�x�[�X�G���[';
            // $e->getMessage() �ŃG���[���e���Q�Ɖ\�i�f�o�b�O���̂ݕ\���j
            // echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = '�p�X���[�h�Ɍ�肪����܂��B';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>�V�K�o�^</title>
    </head>
    <body>
        <h1>�V�K�o�^���</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>�V�K�o�^�҃t�H�[��</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="username">���[�U�[��</label><input type="text" id="username" name="username" placeholder="���[�U�[�������" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">�p�X���[�h</label><input type="password" id="password" name="password" value="" placeholder="�p�X���[�h�����">
                <br>
                <label for="password2">�p�X���[�h(�m�F�p)</label><input type="password" id="password2" name="password2" value="" placeholder="�ēx�p�X���[�h�����">
                <br>
                <input type="submit" id="signUp" name="signUp" value="�V�K�o�^">
            </fieldset>
        </form>
        <br>
        <form action="Login.php">
            <input type="submit" value="�߂�">
        </form>
    </body>
</html>