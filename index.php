<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

// ログインしてるユーザー名とIDを取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

// projectテーブルと接続
$sql = "SELECT * FROM project";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//usersテーブルと接続
$sql = "SELECT * FROM users WHERE user_id=:user_id";
$res = $pdo->prepare($sql);
$res->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$state = $res->execute();
$val = $res->fetch();

if ($state==false) {
    $error = $res->errorInfo();
    exit("SQLError:".$error[2]);
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/main.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <div class="header">
            <!-- ヘッダー -->
            <div class="header-box">
                <div class="logo">
                    <a href="index.php">Team K</a>
                </div>
                <div class="nav-box">
                    <ul class="menu">
                        <?php if ($user_id == 0): ?>
                        <li class="menu-list"><a href="auth/signup.php">サインアップ</a></li>
                        <li class="menu-list"><a href="auth/login.php">ログイン</a></li>
                        <?php else: ?>
                        <li class="menu-list">
                            こんにちは、<?= $username ?>
                        </li>
                        <li class="menu-list"><a href="profile.php">マイプロフィール</a></li>
                        <li class="menu-list"><a href="user_schedule.php">予約一覧</a></li>
                        <li class="menu-list"><a href="favorites.php">お気に入り一覧</a></li>

                        <!-- ログインユーザーがすでにhost登録した場合のみ表示 -->
                        <?php if ($val["host"] == 1): ?>
                        <li class="menu-list"><a href="host_index.php">ホスト管理画面</a></li>
                        <?php endif; ?>

                        <li class="menu-list"><a href="auth/logout.php">ログアウト</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- ヘッダー終わり -->
        </div>

        <!-- メインビュー -->
        <div class="firstview">
            <div class="firstview-img">
                <img src="./background_img/top.png" alt="サイトのファーストビュー">
            </div>
            <div class="firstview-text">
                <p>知らない場所には</p>
                <p>知らない人がいる</p>
            </div>
            <div class="back-color"></div>
            <!-- メインビュー終わり -->
        </div>

        <!-- プラン一覧を表示 -->
        <div class="main">
            <h1 class="title">新着の体験</h1>
            <div class="box">
                <?php foreach ($stmt as $content): ?>
                <div class="content">
                    <div class="content-img">
                        <!-- projectの画像と文字に詳細画面へのリンクを付与
                        URLでuser_idとproject_idを遷移先ページへと引き渡す-->
                        <a href="./selected_project.php?user_id=<?= $user_id ?>&project_id=<?= $content['project_id'] ?>
                            ">
                            <img src='<?= $content["project_img"] ?>'
                                alt="体験できるプロジェクトの画像">
                    </div>
                    <div class="content-title">
                        <?= $content["title"] ?>
                    </div>
                    <div class="content-text">
                        <?= $content["experience"] ?>
                    </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- プラン一覧を表示終わり -->

    </div>
</body>

</html>