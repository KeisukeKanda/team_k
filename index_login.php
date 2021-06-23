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

$username = $_SESSION["name"];

$sql = "SELECT * FROM project";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <!-- ヘッダー -->
        <div class="header">
            <div class="header-box">
                <div class="logo">Team K</div>
                <div class="nav-box">
                    <ul>
                        <li>
                            こんにちは、<?= $username ?>
                        </li>
                        <li><a href="profile.php">マイページ</a></li>
                        <li><a href="auth/logout.php">ログアウト</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ヘッダー終わり -->

        <!-- メインビュー -->
        <div class="main">
            <div class="main-img"></div>
            <div class="main-text">
                <p>知らない場所には</p>
                <p>知らない人がいる</p>
            </div>
            <!-- メインビュー終わり -->
        </div>

        <!-- プラン一覧を表示 -->
        <div class="main">
            <div class="box">
                <?php foreach ($stmt as $content): ?>
                <div class="content">
                    <div class="content-img">
                        <img src="<?= $content["project_img"] ?>"
                            alt="">
                    </div>
                    <div class="content-title">
                        <?= $content["title"] ?>
                    </div>
                    <div class="content-text">
                        <?= $content["experience"] ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- プラン一覧を表示終わり -->

    </div>
</body>

</html>