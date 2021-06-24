<?php
// session_start();

require("db_set/db.php");
// require_once 'funcs.php';
// sschk();
// $pdo = connectDB();
// $id = $_SESSION["id"];

// $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $id, PDO::PARAM_INT);
// $stmt->execute();
// $result = $stmt->fetch();

//******************************************* */
//               予約設定表示
//******************************************* */

	$sql="SELECT*FROM project WHERE user_id=1";
	// $sql="SELECT*FROM reservation WHERE user_id=1 AND reserve_flag=1 ORDER BY date ASC";
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

	$sql="SELECT*FROM reservation WHERE user_id=1 ORDER BY date ASC";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view2="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view2.='<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].'</div><br>';}
	}

	//******************************************* */
//               予約済み表示
//******************************************* */

	$sql="SELECT*FROM reservation WHERE user_id=1 AND reserve_flag=1 ORDER BY date ASC";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view3="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view3.='<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].'??さんが予約した</div><br>';}
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
											<input type="hidden" name="user_id" id="user_id" value="1" />
										</div>
									<div class="actions">
										<input type="submit" value="Create Project" />
									</div>
								</form>
							</section>
						</div>
					</section>

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
