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


//ログイン済みユーザーIDと名を取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];


// 生年月日フォーム用
for ($i=1920; $i <= 2010; $i++) {
    $year .= '<option value="'.$i.'">'.$i.'年</option>';
}
for ($i=1; $i <= 12; $i++) {
    $month .= '<option value="'.$i.'">'.$i.'月</option>';
}
for ($i=1; $i <= 31; $i++) {
    $day .= '<option value="'.$i.'">'.$i.'日</option>';
}


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

    <!-- bootstrapのurl -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/profile_edit.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>

        <div class="main">

            <!-- プロフィールアップデートフォーム -->
            <form action="profile_update.php" method="post" enctype="multipart/form-data">
                <div class="box">

                    <!-- ユーザープロフィール画像 -->
                    <div class="user-img">
                        <div class="img-box">
                            <div class="img-review">
                                <img src="background_img/profile-default.svg" class="preview" alt="変更したいプロフィールの画像">
                            </div>
                            <input type="file" class="image-input" name="user_img">
                        </div>
                    </div>

                    <!-- プロフィールテキスト -->
                    <div class="user-info">
                        <div class="title">ニックネーム</div>
                        <input class="nickname" type="text" name="nickname"
                            value="<?= $val['nickname'] ?>"
                            placeholder="例：旅行 好太郎" required>

                        <div class="title">生年月日</div>
                        <select name="year" class="selected"
                            value="<?= $val['year'] ?>"><?= $year ?></select>
                        <select name="month" class="selected"
                            value="<?= $val['month'] ?>"><?= $month ?></select>
                        <select name="day" class="selected"
                            value="<?= $val['day'] ?>"><?= $day ?></select>

                        <div class="title">性別</div>
                        <input type="radio" name="sex" value="men" checked="checked" />men
                        <input type="radio" name="sex" value="women" />women

                        <div class="title">住んでいる国</div>
                        <input class="country" type="text" name="country"
                            value="<?= $val['country'] ?>"
                            placeholder="例：日本">

                        <div class="title">住んでいるエリア</div>
                        <input class="user_area" type="text" name="user_area"
                            value="<?= $val['user_area'] ?>"
                            placeholder="例：東京">

                        <div class="title">自己紹介</div>
                        <textarea name="introduction" class="introduction"
                            placeholder="はじめまして、旅行好太郎です！世界の多様な価値観に触れてみたいと思い登録しました。どうぞよろしくお願いします！"
                            required><?= $val['introduction'] ?></textarea><br>
                        <input type="submit" class="edit-comp" value="プロフィールを更新">
            </form>
        </div>
    </div>
    <!-- プロフィールアップデートフォーム終わり -->

    <!-- フッターを呼び出し -->
    <?php include("component/footer.php") ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/profile_edit.js"></script>
</body>

</html>