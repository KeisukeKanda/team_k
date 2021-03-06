<?php

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

$project_id = filter_input(INPUT_GET, "id");

//******************************************* */
//               予約設定表示
//******************************************* */

    $sql="SELECT*FROM reservation AS r JOIN project AS p ON r.project_id = p.project_id WHERE p.user_id=$user_id ORDER BY date ASC";

    $stmt=$pdo->prepare($sql);
    $status=$stmt->execute();
    $view="";
    if ($status==false) {
        sql_error($stmt);
    } else {
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $view1.='<div>日付： '.$result["date"].' 時間：'.$result["reservation_time"].'  ';
            $view1 .= '<div class="btn_card">';
            $view1.='<div class="btn"><a href="schedule_edit.php?id='.$result["reservation_id"].'"   >編集</a></div>'.'  ';
            $view1.='<div class="btn"><a href="schedule_delete.php?id='.$result["reservation_id"].'"   >削除</a></div></div>';
            $view1.='</div><br>';
        }
    }

//******************************************* */
//               予約済み表示
//******************************************* */

    $sql="SELECT*FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id
	INNER JOIN users AS u ON r.user_id = u.user_id
	WHERE p.user_id=$user_id AND reserve_flag=1 ORDER BY date ASC";

    $stmt=$pdo->prepare($sql);
    $status=$stmt->execute();
    $view2="";
    if ($status==false) {
        sql_error($stmt);
    } else {
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $view2 .= '<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].' by '.$result["name"].'さんが予約した';
            $view2 .= '<div class="btn_card">';
            $view2 .= '<a href="mail_input.php"  class="btn">mail</a>'.'  ';
            $view2 .= '<a href="service_main.php"  class="btn">tour</a></div>';
            $view2 .= '</div><br>';
        }
    }


?>


<!DOCTYPE HTML>
<html>

<head>
	<title>ISEKAI</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="./css/reset.css">
	<link rel="stylesheet" href="./css/all.css">
	<link rel="stylesheet" href="./css/header.css">
	<link rel="stylesheet" href="./css/footer.css">
	<link rel="stylesheet" href="./css/schedule.css">
</head>

<body>

	<?php include("component/header.php"); ?>

	<!-- ****************************************** -->
	<!--             予約設定入力 -->
	<!-- ****************************************** -->
	<div class="box">
		<h1 class="main-title">スケジュール設定フォーム</h1>
		<div class="form">
			<form method="POST" action="schedule_insert.php" enctype="multipart/form-data">
				<div class="form_box">
					<div>
						<input type="hidden" name="project_id" id="project_id"
							value="<?= $project_id  ?>" />
					</div>
					<div>
						<div class="title">日程</div>
						<input type="date" name="date" id="date" />
					</div>
					<div>
						<div class="title">時間</div>
						<input type="time" name="reservation_time" id="reservation_time" />
					</div>
					<div>
						<input type="hidden" name="reserve_flag" id="reserve_flag" value="0" />
					</div>
				</div>

				<div class="nav_btn">
					<input type="submit" value="設定" class="btn" />
					<input type="reset" value="クリア" class="btn" />
				</div>
			</form>
		</div>


		<!-- ****************************************** -->
		<!--             予約設定一覧 -->
		<!-- ****************************************** -->

		<div class="view_wrap">
			<div class="wrap1">
				<h1 class="main-title">予約設定一覧</h1>
				<p><?php echo $view1;?>
				</p>
			</div>

			<!-- <div class="wrap2">
			<h1 class="align_left">予約済み一覧</h1>
			<p><?php echo $view2;?>
			</p>
		</div> -->
	</div>
	</div>
	<?php include("component/footer.php") ?>

</body>

</html>