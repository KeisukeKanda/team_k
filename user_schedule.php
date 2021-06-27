<?php
//必ずsession_startは最初に記述
session_start();

//DB接続します
require("funcs.php");
require("db_set/db.php");

//セッションハイジャック対策
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
  echo "Login Error!";
  exit();
} else {
  session_regenerate_id(true);
  $_SESSION["chk_ssid"] = session_id();
}

//ユーザー名を取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

//２．データ抽出SQL作成
$sql = "SELECT * FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id  WHERE r.user_id=:user_id AND reserve_flag=1 ORDER BY date ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$status = $stmt->execute();


//３．データ表示
$view = "";
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:" . $error[2]);
} else {
  // $project_id = $res["project_id"];
  //Selectデータの数だけ自動でループしてくれる
  while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<div class="user_reservation">';
    $view .= '<div class="user_reservation_list">';
    $view .= '<div class="reservation_img"><img src="project_img/' . $res["project_img"] . '" alt="" width="200"></div>';
    $view .= '<div class="reservation_contents">';
    $view .= '<div class="project_title"><i class="fas fa-globe"></i> ' . $res["title"] . '</div>';
    $view .= '<div class="project_contents"><i class="fas fa-table"></i> ' . $res["date"] . " " . $res["reservation_time"] . '</div>';
    // $view .= '<p>' . $res["category"] . '</p>';
    $view .= '<div class="project_contents"><i class="fas fa-search-location"></i> ' . $res["country"] . " " . $res["project_area"] . '</div>';
    // $view .= '<p>' . $res["project_area"] . '</p>';
    // $view .= '<p>' . $res["experience"] . '</p>';
    // $view .= '<p>' . $res["thoughts"] . '</p>';
    // $view .= '<p>' ."ツアー時間:". $res["tour_time"] . "時間".'</p>';
    // $view .= '<p>' ."料金". $res["price"] . "円".'</p>';
    $view .= '</div>';
    // $view .= '<div class="project_button">';
    $view .= '<a href="user_schedule_cancel.php?reservation_id=' . $res["reservation_id"] . '" class="btn cancel">× 予約のキャンセル</a>';
    $view .= '<a href="user_schedule_detail.php?reservation_id=' . $res["reservation_id"] . '" class="btn detail">詳細</a>';
    $view .= '</div>';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ユーザー予約一覧</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/all.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/user_schedule.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
  <header>
    <!-- componentフォルダからヘッダーを読み込み -->
    <?php include("component/header.php") ?>
  </header>
  <main>
    <div class="contents">
      <h1>予約一覧</h1>
      <div><?= $view ?></div>
    </div>
    <!-- フッターを呼び出し -->
  </main>
  <footer>
    <?php include("component/footer.php") ?>
  </footer>
</body>

</html>
