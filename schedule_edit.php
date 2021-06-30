<?php
// session_start();

require("./dbset/dbset.php");
require_once 'funcs.php';
session_start();

//セッションハイジャック対策
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()) {
    echo "Login Error!";
    exit();
} else {
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
}

//ユーザー名を取得
$user_id = $_SESSION["user_id"];
$name= $_SESSION["name"];

$reservation_id = filter_input( INPUT_GET, "id" );

$sql = 'SELECT * FROM reservation WHERE reservation_id = :reservation_id LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();

?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>teamk</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/host.css">
	</head>
	<body>

        <?php include("component/header.php"); ?>

<!-- ****************************************** -->
<!--             予約設定入力 -->
<!-- ****************************************** -->
						<h1>Schedule Edit Form</h1>
						<div class="form">
								<form method="POST" action="schedule_update.php" enctype="multipart/form-data">
									<div class="form_box">
										<div>
											<input type="hidden" name="user_id" id="user_id" value="<?=$result["user_id"] ?>" />
										</div>
										<div>
											<div class="title">Project ID</div>
											<input type="text" name="project_id" id="project_id" value="<?=$result["project_id"] ?>" />
										</div>
										<div>
											<div class="title">Date</div>
											<input type="date" name="date" id="date" value="<?=$result["date"] ?>" />
										</div>
										<div>
											<div class="title">Time</div>
											<input type="time" name="reservation_time" id="reservation_time" value="<?=$result["reservation_time"] ?>" />
										</div>
										<div>
											<input type="hidden" name="reserve_flag" id="reserve_flag" value="<?=$result["reserve_flag"] ?>" />
										</div>
										<div>
											<input type="hidden" name="reservation_id" id="reservation_id" value="<?=$result["reservation_id"] ?>" />
										</div>
									<div class="nav_btn">
										<input type="submit" value="Edit" class="btn main" />
										<input type="reset" value="Clear" class="btn main" />
									</div>
								</form>
						</div>

    <?php include("component/footer.php") ?>

	</body>
</html>
