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
        // $view .= '<div><a href="./selected_project.php?user_id=' . $user_id . '&project_id=' . $result['project_id'] . '">' .
        //     '<img src="project_img/' . $result["project_img"] . '" alt="" width="200"/></div>';
        $view .= '<div><img src="project_img/' . $result["project_img"] . '" alt="" width="200"/></div>';
        $view .= '<div class="favorite_contents">';
        // $view .= '<div> Project:' . $result["project_id"] . '</div>';
        $view .= '<div class="project_title"><i class="fas fa-globe"></i> ' . $result["title"] . '</div>';
        $view .= '<div class="project_contents">○ カテゴリー: ' . $result["category"] . '</div>';
        $view .= '<div class="project_contents">○ 案内する場所: ' . $result["country"] . " " . $result["project_area"] . '</div>';
        $view .= '<div class="project_contents">○ 内容:' . $result["experience"] . '</div>';
        $view .= '<div class="project_contents">○ ホストの思い:' . $result["thoughts"] . '</div>';
        $view .= '<div class="project_contents">○ ツアー時間:' . $result["tour_time"] . "時間" . '</div>';
        $view .= '<div class="project_contents">○ 料金:' . $result["price"] . "円" . '</div>';
        $view .= '</div>';
        $view .= '</div>';
        $view .= '<a href="./selected_project.php?user_id=' . $user_id . '&project_id=' . $result['project_id'] . '" class="btn go">予約する</a>';
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
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>お気に入り一覧</title>
</head>

<body>
    <header>
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>
    </header>
    <main>
        <div class="contents">
            <!-- お気に入り一覧を表示 -->
            <h1>お気に入り一覧</h1>
            <?php echo $view; ?>
            <!-- プラン一覧を表示終わり -->
        </div>
    </main>
    <footer>
        <?php include("component/footer.php") ?>
    </footer>
</body>

</html>
