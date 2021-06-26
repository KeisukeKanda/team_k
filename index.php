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
    <link rel="stylesheet" href="./css/header.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>

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
        </div>
        <!-- メインビュー終わり -->

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