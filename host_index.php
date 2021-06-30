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


//******************************************* */
//               Project一覧表示
//******************************************* */

	// $sql="SELECT*FROM project WHERE user_id=1";
	$sql="SELECT*FROM project WHERE user_id=$user_id";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view1="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
	    $view1 .= '<div class="p_card">';
	    $view1 .= '<div class="img_card">';
	    $view1 .=	'<img src="project_img/'.$result["project_img"].'" alt="" width="200" /></div>';
			$view1 .= '<div class="txt_card">';
			$view1 .= '<div class="txt_title_card">';
			$view1 .= 'Project:'.$result["project_id"].'  '.$result["title"].' Category: '.$result["category"].'</div>';
			$view1 .= '<div class="txt_country_card">'.$result["country"].'  '.$result["project_area"].'</div>';
			$view1 .= '<div class="txt_expe_card">'.$result["experience"].'</div>';
			$view1 .= '<div class="txt_thoughts_card">'.$result["thoughts"].'</div>';
			$view1 .= '<div class="txt_time_price_card">Tour time: '.$result["tour_time"].'　　　Price:'.$result["price"].'</div>';
			$view1 .= '<div class="btn_card">';
			$view1 .= '<a href="schedule.php?id='.$result["project_id"].'" class="btn">schedule</a>'.'  ';
			$view1 .= '<a href="project_edit.php?id='.$result["project_id"].'" class="btn">edit</a>'.'  ';
			$view1 .= '<a href="project_delete.php?id='.$result["project_id"].'" class="btn">delete</a></div>';
			$view1 .= '</div></div><br>';}
	}

//******************************************* */
//               予約設定表示
//******************************************* */

	$sql="SELECT*FROM reservation AS r JOIN project AS p ON r.project_id = p.project_id WHERE p.user_id=$user_id AND reserve_flag=0 ORDER BY p.project_id ASC";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view2="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view2 .= '<div class="s_card">';
			$view2 .= '<div class="txt_expe_card"> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].'</div>  ';
			$view2 .= '<div class="btn_card">';
			$view2 .= '<a href="schedule_edit.php?id='.$result["reservation_id"].'" class="btn">edit</a>'.'  ';
			$view2 .= '<a href="schedule_delete.php?id='.$result["reservation_id"].'" class="btn">delete</a></div>';
			$view2 .= '</div><br>';}
	}

	//******************************************* */
//               予約済み表示
//******************************************* */

	$sql="SELECT*FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id
	INNER JOIN users AS u ON r.user_id = u.user_id
	WHERE p.user_id=$user_id AND reserve_flag=1 ORDER BY p.project_id ASC";

	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view3="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view3.= '<div class="r_card">';
			$view3 .= '<div class="txt_expe_card">Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].' by '.$result["name"].'さんが予約した </div> ';
			$view3 .= '<div class="btn_card">';
			$view3 .= '<a href="mail_input.php"  class="btn">mail</a>'.'  ';
			$view3 .= '<a href="service_main.php"  class="btn">tour</a></div>';
			$view3 .= '</div><br>';}
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
    <link rel="stylesheet" href="./css/host.css">
	</head>
	<body>
    <div class="wrap">
	        <!-- includeフォルダからヘッダーを読み込み -->
        <?php include("component/header.php"); ?>

<!-- ****************************************** -->
<!--             project.php へ飛ぶボタン-->
<!-- ****************************************** -->

						<h1>Host Index</h1>
						<div class="nav_btn">
								<form method="POST" action="project.php" enctype="multipart/form-data">
									<div>
										<input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>" />
									</div>
									<div class="actions">
										<input type="submit" value="プロジェクト作成" class="btn main"/>
									</div>
								</form>
						</div>

<!-- ****************************************** -->
<!--             hostが作ったProjectの一覧 -->
<!-- ****************************************** -->

			<div>
					<h2>予約済み一覧</h2>
					<p><?php echo $view3;?></p>
			</div>

			<div class="view_wrap">
				<div class="wrap1">
						<h2>Project一覧</h2>
						<p><?php echo $view1;?></p>
				</div>

				<div class="wrap2">
						<h2>予約設定一覧</h2>
						<p><?php echo $view2;?></p>
				</div>
			</div>



    <!-- フッターを呼び出し -->
    <?php include("component/footer.php") ?>
	</body>
</html>
