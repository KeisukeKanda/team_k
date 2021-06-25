<?php

require("db_set/db.php");
require_once 'funcs.php';
session_start();
$user_id = $_SESSION["user_id"];
$name= $_SESSION["name"];


//******************************************* */
//               予約設定表示
//******************************************* */

	// $sql="SELECT*FROM project WHERE user_id=1";
	$sql="SELECT*FROM project WHERE user_id=$user_id";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view1.='<img src="project_img/'.$result["project_img"].'" alt="" />'.
			'<div> Project:'.$result["project_id"].' Title: '.$result["title"].' Category: '.$result["category"].'  '.
			'Country:'.$result["country"].' Area: '.$result["project_area"].'  '.
			'Experience:'.$result["experience"].' Thought: '.$result["thoughts"].' Tour time: '.$result["tour_time"].'  '.
			'Price:'.$result["price"].'  '.
			'<a href="schedule.php?id='.$result["project_id"].'">schedule</a>'.'  '.
			'<a href="project_edit.php?id='.$result["project_id"].'">edit</a>'.'  '.
			'<a href="project_delete.php?id='.$result["project_id"].'">delete</a>'.
			'</div><br>';}
	}

//******************************************* */
//               予約設定表示
//******************************************* */

	$sql="SELECT*FROM reservation AS r JOIN project AS p ON r.project_id = p.project_id WHERE p.user_id=$user_id ORDER BY date ASC";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view2="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view2.='<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].'  '.
			'<a href="schedule_edit.php?id='.$result["reservation_id"].'">edit</a>'.'  '.
			'<a href="schedule_delete.php?id='.$result["reservation_id"].'">delete</a>'.
			'</div><br>';}
	}

	//******************************************* */
//               予約済み表示
//******************************************* */

	$sql="SELECT*FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id
	INNER JOIN users AS u ON r.user_id = u.user_id
	WHERE p.user_id=$user_id AND reserve_flag=1 ORDER BY date ASC";

	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view3="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view3.='<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].' by '.$result["name"].'さんが予約した  '.
			'<a href="mail_input.php">mail</a>'.'  '.
			'</div><br>';}
	}

?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>teamk</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	</head>
	<body>

<!-- ****************************************** -->
<!--             project.php へ飛ぶボタン-->
<!-- ****************************************** -->
					<section>
						<h3>Host Index</h3>
						<div>
							<section>
								<form method="POST" action="project.php" enctype="multipart/form-data">
									<div>
										<div>
											<!-- <input type="hidden" name="user_id" id="user_id" value="1" /> -->
											<input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>" />
										</div>
									<div class="actions">
										<input type="submit" value="Create Project" />
									</div>
								</form>
							</section>
						</div>
					</section>

          <a href="index.php">メインへ戻る</a>

<!-- ****************************************** -->
<!--             hostが作ったProjectの一覧 -->
<!-- ****************************************** -->

		<div>
        <h4>Project一覧</h4>
        <p><?php echo $view1;?></p>
    </div>

		<div>
        <h4>予約設定一覧</h4>
        <p><?php echo $view2;?></p>
    </div>
		<div>
        <h4>予約済み一覧</h4>
        <p><?php echo $view3;?></p>
    </div>

	</body>
</html>
