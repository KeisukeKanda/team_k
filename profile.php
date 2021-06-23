<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

$username = $_SESSION["name"];

// usersテーブルのデータを取得
$sql = "SELECT * FROM court WHERE place LIKE '%".$area."%' AND station LIKE '%".$station."%' AND distance LIKE '%".$distance."%'";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


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
        <!-- ヘッダー -->
        <div class="header">
            <div class="header-box">
                <div class="logo">Team K</div>
                <div class="nav-box">
                    <ul>
                        <li>
                            こんにちは、<?= $username ?>
                        </li>
                        <li><a href="index_login.php">メインへ戻る</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ヘッダー終わり -->

        <div class="main">
            <div class="box">

                <!-- プロフィールアップデートフォーム -->
                <form action="profile_update.php" method="post" enctype="multipart/form-data">
                    <div>プロフィール画像</div>
                    <input type="file" name="user_img">
                    <div>ニックネーム</div>
                    <input type="text" name="nickname">
                    <div>生年月日</div>
                    <input type="date" name="birthdate">
                    <!-- <select name="year"><?= $year ?></select>
                    <select name="month"><?= $month ?></select>
                    <select name="day"><?= $day ?></select> -->
                    <div>性別</div>
                    <input type="radio" name="sex" value="男" checked="checked" />男
                    <input type="radio" name="sex" value="女" />女
                    <div>住んでいる国</div>
                    <select name="country">
                        <option value=""></option>
                        <option value="日本">日本</option>
                        <option value="中国">中国</option>
                    </select>
                    <div>住んでいるエリア</div>
                    <select name="user_area">
                        <option value=""></option>
                        <option value="東京">東京</option>
                        <option value="大阪">大阪</option>
                    </select>
                    <div>自己紹介</div>
                    <textarea name="introduction"></textarea><br>
                    <input type="submit" value="プロフィールを更新">
                </form>
                <!-- プロフィールアップデートフォーム終わり -->

            </div>
        </div>
    </div>

</body>

</html>