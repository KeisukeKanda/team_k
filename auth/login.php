<?php
session_start();

// DB接続とfancs.phpを読み込
require("../db_set/db.php");
require("../funcs.php");

//CSRF対策
$csrfToken = csrf();
$_SESSION['csrfToken'] = $csrfToken;


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <div class="box">
            <form action="login_act.php" method="post">
                <div>ユーザーID（emailアドレス）</div>
                <input type="text" name="login_id" required>
                <div>パスワード（6文字以上）</div>
                <input type="password" name="password" required pattern="(?=.*\d).{6,}" title="6文字以上のパスワードを入力してください。">
                <input type='hidden' name='csrfToken'
                    value='<?= $csrfToken ?>'><br>
                <input type="submit" value="ログイン">
            </form>
            <div>
                まだサインインがお済みでない方は
                <a href="signup.php">こちら</a>
            </div>
            <a href="../index.php">戻る</a>
        </div>
    </div>
    <script src="../js/sweetalert2.all.min.js"></script>
</body>

</html>