<?php
session_start();

require("../db/database.php");
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
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <div class="box">
            <form action="login_act.php" method="post">
                <label>ユーザーID</label>
                <input type="text" name="login_id">
                <label>パスワード</label>
                <input type="password" name="password">
                <input type='hidden' name='csrfToken'
                    value='<?= $csrfToken ?>'>
                <input type="submit" value="送信">
            </form>
        </div>
    </div>

</body>

</html>