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
                <div>ユーザー名</div><input type="text" name="name" required><br>
                <div>ユーザーID</div><input type="text" name="email" required><br>
                <div>パスワード</div><input type="password" name="password" required><br>
                <input type='hidden' name='csrfToken'
                    value='<?= $csrfToken ?>'>
                <input type="submit" value="サインイン">
            </form>
        </div>
    </div>

</body>

</html>