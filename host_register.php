<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

//セッションハイジャック対策
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()) {
    echo "Login Error!";
    exit();
} else {
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
}

//ユーザー名を取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

//usersテーブルと接続
$sql = "SELECT * FROM users AS u INNER JOIN country AS c ON u.country=c.country_id INNER JOIN japan AS j ON u.user_area=j.japan_id WHERE user_id=:user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if ($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/host_register.css">
    <title>ISEKAI</title>
</head>

<body>
    <div class="wrap">
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>


        <div class="main">
            <div class="box">
                <div class="sub">
                    <form action="host_register_act.php" method="post">
                        <input type="hidden" name="host" value="1">
                        <input type="submit" class="btn host-btn" value="ホストになる">
                    </form>
                </div>
            </div>
        </div>
        <!-- フッターを呼び出し -->
        <?php include("component/footer.php") ?>
        <style>
            .user_img {
                width: 30%;
            }

            .user_img img {
                width: 100%;
            }
        </style>

</body>

</html>