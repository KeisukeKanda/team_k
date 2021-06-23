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

	$sql="SELECT*FROM reservation WHERE user_id=1 AND reserve_flag=0 ORDER BY date ASC";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view1.='<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].'  '.
			'<a href="schedule_edit.php?id='.$result["reservation_id"].'">edit</a>'.'  '.
			'<a href="schedule_delete.php?id='.$result["reservation_id"].'">delete</a>'.
			'</div><br>';}
	}

//******************************************* */
//               予約済み表示
//******************************************* */

	$sql="SELECT*FROM reservation WHERE user_id=1 AND reserve_flag=1 ORDER BY date ASC";
	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view2="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view2.='<div> Project'.$result["project_id"].' on '.$result["date"].' at '.$result["reservation_time"].'　　?さんが予約した</div><br>';}
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
<!--             予約設定入力 -->
<!-- ****************************************** -->
					<section>
						<h3>Schedule Form</h3>
						<div>
							<section>
								<form method="POST" action="schedule_insert.php" enctype="multipart/form-data">
									<div>
										<div>
											<label for="user_id">User ID</label>
											<input type="text" name="user_id" id="user_id" value="1" />
										</div>
										<div>
											<label for="project_id">Project ID</label>
											<input type="text" name="project_id" id="project_id" value="1" />
										</div>
										<div>
											<label for="date">Date</label>
											<input type="date" name="date" id="date" />
										</div>
										<div>
											<label for="reservation_time">Time</label>
											<input type="time" name="reservation_time" id="reservation_time" />
										</div>
										<div>
											<input type="hidden" name="reserve_flag" id="reserve_flag" value="0" />
										</div>
									<div class="actions">
										<input type="submit" value="Propose" />
										<input type="reset" value="Clear" />
									</div>
								</form>
							</section>
						</div>
					</section>

<!-- ****************************************** -->
<!--             予約設定一覧 -->
<!-- ****************************************** -->

		<div>
        <h4>予約設定一覧</h4>
        <p><?php echo $view1;?></p>
    </div>

		<div>
        <h4>予約済み一覧</h4>
        <p><?php echo $view2;?></p>
    </div>

	</body>
</html>
