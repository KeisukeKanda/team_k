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
$sql = "SELECT * FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id  WHERE r.user_id=:user_id ORDER BY date ASC";
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
    $view .= '<li class="user_reservation_list">';
    $view .= '<p>' . $res["date"] . "|" . $res["reservation_time"] . '</p>';
    $view .= '<p><img src="project_image' . $res["project_img"] . '" alt="" width="200"></p>';
    $view .= '<p>' . $res["title"] . '</p>';
    $view .= '<p>' . $res["category"] . '</p>';
    $view .= '<p>' . $res["country"] . '</p>';
    $view .= '<p>' . $res["project_area"] . '</p>';
    $view .= '<p>' . $res["experience"] . '</p>';
    $view .= '<p>' . $res["thoughts"] . '</p>';
    $view .= '<p>' . $res["tour_time"] . '</p>';
    $view .= '<p>' . $res["price"] . '</p>';
    $view .= '<a href="user_schedule_detail.php?id=' . $res["project_id"] . '">詳細</a>';
    $view .= '</li>';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ユーザー予約一覧</title>
  <link rel="stylesheet" href="css/reset.css">
</head>

<body>
  <div><?= $view ?></div>
</body>

</html>