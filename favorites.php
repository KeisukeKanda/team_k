<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

// ログインしてるユーザー名とIDを取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

//******************************************* */
//               お気に入り表示
//******************************************* */

$sql = "SELECT*FROM favorites AS f INNER JOIN project AS p ON f.project_id = p.project_id
	WHERE f.user_id=$user_id";

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="user_favorite">';
        $view .= '<div class="user_favorite_list">';
        $view .= '<a href="./selected_project.php?user_id=' . $user_id . '&project_id=' . $result['project_id'] . '">' .
            '<img src="project_img/' . $result["project_img"] . '" alt="" width="200"/>';
        $view .= '<div> Project:' . $result["project_id"] . ' </div>';
        $view .= '<div>Title: ' . $result["title"] . '</div>';
        $view .= '<div>Category: ' . $result["category"] . '  ' .'</div>';
        $view .= '<div>Country:' . $result["country"] . ' Area: ' . $result["project_area"] . '  ' .'</div>';
        $view .= '</div>';
        $view .= '</div>';
    }
}

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
    <link rel="stylesheet" href="./css/favorites.css">
    <link rel="stylesheet" href="./css/footer.css">
    <title>Document</title>
</head>
<body>
    <header>
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>
    </header>
    <div class="contents">
        <!-- お気に入り一覧を表示 -->
        <h1>お気に入り一覧</h1>
        <p><?php echo $view; ?></p>
        <!-- プラン一覧を表示終わり -->

    </div>

    <!-- <style>
        .content-img {
            width: 30%;
        }

        .content-img img {
            width: 100%;
        }
    </style> -->
    <footer>
        <?php include("component/footer.php") ?>
    </footer>
</body>

</html>
