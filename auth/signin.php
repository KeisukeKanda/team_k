<?php

session_start();

// DB接続とfancs.phpを読み込み
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
            <form action="signin_act.php" method="post">
                <div>ユーザー名（ニックネーム）</div><input type="text" name="name" required><br>
                <div>ユーザーID（emailアドレス）</div><input type="text" name="email" required><br>
                <div>パスワード（6文字以上）</div><input type="password" name="password" required pattern="(?=.*\d).{6,}"
                    title="6文字以上のパスワードを入力してください。"><br>
                <input type='hidden' name='csrfToken'
                    value='<?= $csrfToken ?>'>
                <input type="submit" value="サインイン">
            </form>
            <div>
                すでにアカウントがある方は
                <a href="login.php">こちら</a>
            </div>
            <a href="../index.php">戻る</a>
        </div>
    </div>

</body>

</html>