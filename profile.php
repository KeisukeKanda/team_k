<?php

session_start();

require("./dbset/dbset.php");
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
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/profile.css">
    <title>ISEKAI</title>
</head>

<body>
    <div class="wrap">
        <!-- includeフォルダからヘッダーを読み込み -->
        <?php include("component/header.php"); ?>

        <div class="main">
            <div class="box">

                <!-- プロフィール表示 -->
                <div class="user-img">
                    <div class="img-box">
                        <img src="./user_img/<?= $val["user_img"] ?>"
                            alt="ユーザープロフィール画像">

                        <!-- 編集ページへの移動ボタン -->
                        <div class="edit">
                            <a href="profile_edit.php">プロフィール編集</a>
                        </div>

                        <!-- ログインユーザーがまだhost登録していない場合のみ表示する -->
                        <?php if ($val["host"] == 0): ?>
                        <div class="host-btn">
                            <a href="host_register.php">ホストに登録する</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="user-info">
                    <div class="title">ニックネーム</div>
                    <div class="text nickname">
                        <?php if ($val["nickname"] !== "NULL"): ?>
                        <?= $val["nickname"] ?>
                        <?php endif; ?>
                    </div>
                    <div class="title">生年月日</div>
                    <div class="text birthdate">
                        <?php if ($val["year"] ==""): ?>
                        <?php else: ?>
                        <?= $val["year"] ?>/
                        <?= $val["month"] ?>/
                        <?= $val["day"] ?>
                        <?php endif; ?>
                    </div>
                    <div class="title">性別</div>
                    <div class="text sex">
                        <?php if ($val["sex"] !== "NULL"): ?>
                        <?= $val["sex"] ?>
                        <?php endif; ?>
                    </div>
                    <div class="title">住んでいる国</div>
                    <div class="text country">
                        <?php if ($val["country"] !== "NULL"): ?>
                        <?= $val["country"] ?>
                        <?php endif; ?>
                    </div>
                    <div class="title">住んでいるエリア</div>
                    <div class="text user_area">
                        <?php if ($val["japan_area"] !== "NULL"): ?>
                        <?= $val["user_area"] ?>
                        <?php endif; ?>
                    </div>
                    <div class="title">自己紹介</div>
                    <div class="text introduction">
                        <?= $val["introduction"] ?>
                    </div>
                </div>
                <!-- プロフィール表示終わり -->

            </div>
        </div>
    </div>

    <!-- ここからsubコンテンツ -->
    <div class="sub">
        <div class="sub-box">

        </div>
    </div>
    <!-- subコンテンツここまで -->

    <!-- フッターを呼び出し -->
    <?php include("component/footer.php") ?>
</body>

</html>
