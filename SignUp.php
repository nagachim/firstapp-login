<?php
// �Z�b�V�����J�n
session_start();

header('Content-Type: text/html; charset=utf-8');

$dbUrl = parse_url(getenv('DATABASE_URL'));

$db['host'] = $dbUrl['host'];  // DB�T�[�o��URL
$db['user'] = $dbUrl['user'];  // ���[�U�[��
$db['pass'] = $dbUrl['pass'];  // ���[�U�[���̃p�X���[�h
$db['dbname'] = ltrim($dbUrl['path'], '/');;  // �f�[�^�x�[�X��

// �G���[���b�Z�[�W�A�o�^�������b�Z�[�W�̏�����
$errorMessage = "";
$signUpMessage = "";

// �V�K�o�^�{�^���������ꂽ�ꍇ
if (isset($_POST["signUp"])) {
    // 1. ���[�UID�̓��̓`�F�b�N
    if (empty($_POST['username'])) {  // �l����̂Ƃ�
        $errorMessage = '���[�U�[ID�������͂ł��B';
    } else if (empty($_POST['password'])) {
        $errorMessage = '�p�X���[�h�������͂ł��B';
    } else if (empty($_POST['password2'])) {
        $errorMessage = '�p�X���[�h�������͂ł��B';
    } else if (empty($_POST['nickname'])){
        $errorMessage = '�j�b�N�l�[���������͂ł�';
    }

    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password2']) && $_POST['password'] === $_POST['password2']) {
        // ���͂������[�UID�ƃp�X���[�h���i�[
        $name = $_POST['username'];
        $pass = $_POST['password'];
        $nickname = $_POST['nickname'];

        //DB�ڑ����쐬
        $connectString = "host={$db['host']} dbname={$db['dbname']} port=5432 user={$db['user']} password={$db['pass']}";
        //DB�ڑ�
        if(!$result = pg_connect($connectString)){
            //�ڑ����s
            $errorMessage = '�\�����ʃG���[������';
            exit();
        }
        
        $select = sprintf("SELECT * FROM userInfo WHERE username='%s'",$name);
        $selectresult = pg_query($select);
        if(!$selectresult){
            
        }else{
            $insert =sprintf("INSERT INTO userInfo( username, password, nickname, logincnt, systimestamp) VALUES ( '%s', '%s', '%s', 0, current_timestamp)",$name,$pass,$nickname);
            
            $insertresult = pg_query($insert);
            $errorMessage = $name;
            $signUpMessage = $pass;
            
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = '�p�X���[�h�Ɍ�肪����܂��B';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="utf-8">
            <title>�V�K�o�^</title>
    </head>
    <body>
        <h1>�V�K�o�^���</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>�V�K�o�^�҃t�H�[��</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="username">���[�U�[���@�@�@�@�@�@�F</label><input type="text" id="username" name="username" placeholder="���[�U�[�������" value="<?php if (!empty($_POST['username'])) {echo htmlspecialchars($_POST['username'], ENT_QUOTES);} ?>">
                <br>
                <label for="password">�p�X���[�h�@�@�@�@�@�@�F</label><input type="password" id="password" name="password" value="" placeholder="�p�X���[�h�����">
                <br>
                <label for="password2">�p�X���[�h�i�m�F�p�j�@�F</label><input type="password" id="password2" name="password2" value="" placeholder="�ēx�p�X���[�h�����">
                <br>
                <label for="nickname">�j�b�N�l�[���@�@�@�@�@�F</label><input type="text" id="nickname" name="nickname" value="" placeholder="�j�b�N�l�[�������">
                <br>
                <input type="submit" id="signUp" name="signUp" value="�o�^">
            </fieldset>
        </form>
        <br>
        <form action="Login.php">
            <input type="submit" value="�߂�">
        </form>
    </body>
</html>