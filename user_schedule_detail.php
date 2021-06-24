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

if (!isset($_GET["reservation_id"]) || $_GET["reservation_id"] == "") {
  exit("ParamError!");
} else {
  $reservation_id = intval($_GET["reservation_id"]); //intval数値変換
}

//２．データ抽出SQL作成
$sql = "SELECT * FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id  WHERE reservation_id=:reservation_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
$status = $stmt->execute();


//３．データ表示
$view = "";
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:" . $error[2]);
} else {
  $row = $stmt->fetch();
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ユーザー予約詳細</title>
  <link rel="stylesheet" href="css/reset.css">
</head>

<body>
  <main>

    <!--詳細ページ-->
    <p><img src="project_img/<?= $row["project_img"] ?>" width="200"></p>
    <div>
      <p><?= $row["title"] ?></p>
      <p>開催日時：<?= $row["date"]." ". $row["reservation_time"] ?></p>
      <!-- <p><?= $row["reservation_time"] ?></p> -->
      <p>カテゴリー：<?= $row["category"] ?></p>
      <p>案内場所：<?= $row["country"]." ". $row["project_area"] ?></p>
      <!-- <p><?= $row["project_area"] ?></p> -->
      <p>体験の内容：<?= $row["experience"] ?></p>
      <p>ホストの思い：<?= $row["thoughts"] ?></p>
      <p>ツアー時間：<?= $row["tour_time"] ?></p>
      <p>価格：<?= $row["price"] ?></p>
    </div>
    <!--遷移ボタン-->
    <div>
      <a href="user_schedule.php">戻る</a>
      <a href="#skyway">参加</a>
    </div>
</body>

</html>
