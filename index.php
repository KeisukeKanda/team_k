<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

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
        <div class="header">
            <!-- ヘッダー -->
            <div class="header-box">
                <div class="logo">Team K</div>
                <div class="nav-box">
                    <ul>
                        <?php if ($user_id == 0): ?>
                        <li><a href="auth/signin.php">サインイン</a></li>
                        <li><a href="auth/login.php">ログイン</a></li>
                        <?php else: ?>
                        <li>
                            こんにちは、<?= $username ?>
                        </li>
                        <li><a href="profile.php">マイプロフィール</a></li>
                        <li><a href="">予約一覧</a></li>
                        <li><a href="">ホスト管理画面</a></li>
                        <li><a href="auth/logout.php">ログアウト</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- ヘッダー終わり -->
        </div>

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
                        <img src='<?= $content["project_img"] ?>'
                            alt=''>
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

    <style>
        .content-img {
            width: 30%;
        }

        .content-img img {
            width: 100%;
        }
    </style>

</body>

</html>