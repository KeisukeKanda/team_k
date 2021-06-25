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

//usersテーブルと国と地域のテーブルを接続
// 国コードと地域コードから国名・地域名をプロフィールに表示させるため
$sql = "SELECT * FROM users AS u 
INNER JOIN country AS c ON u.country=c.country_id 
INNER JOIN japan AS j ON u.user_area=j.japan_id 
WHERE user_id=:user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if ($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

// usersテーブルのみを取得

// ※※
// 上記usersと国・地域コードをINNER JOINしたデータ記述だと、
// 国コード・地域コード入力前の状態では正しく表示されないためこちらのデータ取得を行う
// ※※
$sql = "SELECT * FROM users WHERE user_id=:user_id";
$res = $pdo->prepare($sql);
$res->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$state = $res->execute();
$val = $res->fetch();


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
                <div>プロフィール画像</div>
                <div class="user_img">
                    <img src="<?= $val["user_img"] ?>"
                        alt="ユーザープロフィール画像">
                </div>
                <div>ニックネーム</div>
                <div class="nickname">
                    <?= $val["nickname"] ?>
                </div>
                <div>生年月日</div>
                <div class="birthdate">
                    <?= $val["year"] ?>/
                    <?= $val["month"] ?>/
                    <?= $val["day"] ?>
                </div>
                <div>性別</div>
                <div class="sex">
                    <?= $val["sex"] ?>
                </div>
                <?php foreach ($stmt as $profile): ?>
                <div>住んでいる国</div>
                <div class="country">
                    <?= $profile["country"] ?>
                </div>
                <div>住んでいるエリア</div>
                <div class="user_area">
                    <?= $profile["japan_area"] ?>
                </div>
                <?php endforeach; ?>
                <div>自己紹介</div>
                <div class="introduction">
                    <?= $val["introduction"] ?>
                </div>
                <!-- プロフィール表示終わり -->

                <!-- 編集ページへの移動ボタン -->
                <button><a href="profile_edit.php">編集</a></button>
            </div>
        </div>
    </div>

    <!-- ここからsubコンテンツ -->
    <div class="sub">
        <div class="sub-box">

            <!-- ログインユーザーがまだhost登録していない場合のみ表示する -->
            <?php if ($val["host"] == 0): ?>
            <a href="host_register.php">ホストに登録する</a>
            <?php endif; ?>

        </div>
    </div>
    <!-- subコンテンツここまで -->

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