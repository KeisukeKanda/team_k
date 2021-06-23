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
$sql = "SELECT * FROM users WHERE user_id=:user_id";
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
                        <li><a href="index.php">メインへ戻る</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ヘッダー終わり -->

        <div class="main">
            <div class="box">

                <!-- プロフィール表示 -->
                <?php foreach ($stmt as $profile): ?>
                <div>プロフィール画像</div>
                <div class="user_img">
                    <img src="<?= $profile["user_img"] ?>"
                        alt="">
                </div>
                <div>ニックネーム</div>
                <div class="nickname">
                    <?= $profile["nickname"] ?>
                </div>
                <div>生年月日</div>
                <div class="birthdate">
                    <?= $profile["birthdate"] ?>
                </div>
                <div>性別</div>
                <div class="sex">
                    <?= $profile["sex"] ?>
                </div>
                <div>住んでいる国</div>
                <div class="country">
                    <?= $profile["country"] ?>
                </div>
                <div>住んでいるエリア</div>
                <div class="user_area">
                    <?= $profile["user_area"] ?>
                </div>
                <div>自己紹介</div>
                <div class="introduction">
                    <?= $profile["introduction"] ?>
                </div>
                <!-- プロフィール表示終わり -->

                <!-- 編集ページへの移動ボタン -->
                <button><a href="profile_edit.php">編集</a></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

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