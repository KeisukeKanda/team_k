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
  <link rel="stylesheet" href="css/all.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/user_schedule.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
  <header>
    <?php include("component/header.php") ?>
  </header>
  <main>
    <!--詳細ページ-->
    <div class="contents">
      <h1>予約をキャンセルしてもよろしいですか？</h1>
      <div class="user_reservation">
        <div class="user_reservation_list">
          <div><img src="project_img/<?= $row["project_img"] ?>" width="300"></div>
          <div>
            <div class="project_title"><i class="fas fa-globe"></i> <?= $row["title"] ?></div>
            <div class="project_contents"><i class="fas fa-table"></i> <?= $row["date"] . " " . $row["reservation_time"] ?></div>
            <div class="project_contents">○ カテゴリー</div>
            <div class="project_contents">　<?= $row["category"] ?></div>
            <div class="project_contents">○ 案内する場所</div>
            <div class="project_contents">　<?= $row["country"] . " " . $row["project_area"] ?></div>
            <div class="project_contents">○ 内容</div>
            <div class="project_contents">　<?= $row["experience"] ?></div>
            <div class="project_contents">○ ホストの思い</div>
            <div class="project_contents">　<?= $row["thoughts"] ?></div>
            <div class="project_contents">○ ツアー時間</div>
            <div class="project_contents">　<?= $row["tour_time"] ?>時間</div>
            <div class="project_contents">○ 価格</div>
            <div class="project_contents">　<?= $row["price"] ?>円</div>
            <!--遷移ボタン-->
          </div>
        </div>
        <div class="project_button">
          <div class="btn"><a href="user_schedule.php" class="btn">戻る</a></div>
          <form action="user_schedule_update.php" method="post">
            <input type="hidden" name="reservation_id" value="<?= $row["reservation_id"] ?>">
            <input type="hidden" name="project_id" value="<?= $row["project_id"] ?>">
            <input type="hidden" name="user_id" value="NULL">
            <input type="hidden" name="date" value="<?= $row["date"] ?>">
            <input type="hidden" name="reservation_time" value="<?= $row["reservation_time"] ?>">
            <input type="hidden" name="reserve_flag" value="0">
            <input type="submit" value="キャンセルする" class="yes">
          </form>
        </div>
      </div>
    </div>
    <!-- フッターを呼び出し -->
    <footer>
      <?php include("component/footer.php") ?>
    </footer>
</body>

</html>
