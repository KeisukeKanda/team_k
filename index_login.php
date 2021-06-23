<?php

session_start();

require("../db/database.php");
require("funcs.php");

//セッションハイジャック対策
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()) {
    echo "Login Error!";
    exit();
} else {
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
}

$username = $_SESSION["u_name"];

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
        <div class="header">
            <!-- ヘッダー -->
            <div class="header-box">
                <div class="logo">Team K</div>
                <div class="nav-box">
                    <ul>
                        <li>
                            こんにちは、<?= $username ?>
                        </li>
                        <li>マイページ</li>
                    </ul>
                </div>
            </div>
            <!-- ヘッダー終わり -->
        </div>
    </div>

</body>

</html>