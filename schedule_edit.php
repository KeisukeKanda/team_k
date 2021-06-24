<?php
// session_start();

require("db_set/db.php");
require_once 'funcs.php';
session_start();
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
	</head>
	<body>

<!-- ****************************************** -->
<!--             予約設定入力 -->
<!-- ****************************************** -->
					<section>
						<h3>Schedule Edit Form</h3>
						<div>
							<section>
								<form method="POST" action="schedule_update.php" enctype="multipart/form-data">
									<div>
										<div>
											<input type="hidden" name="user_id" id="user_id" value="<?=$result["user_id"] ?>" />
										</div>
										<div>
											<label for="project_id">Project ID</label>
											<input type="text" name="project_id" id="project_id" value="<?=$result["project_id"] ?>" />
										</div>
										<div>
											<label for="date">Date</label>
											<input type="date" name="date" id="date" value="<?=$result["date"] ?>" />
										</div>
										<div>
											<label for="reservation_time">Time</label>
											<input type="time" name="reservation_time" id="reservation_time" value="<?=$result["reservation_time"] ?>" />
										</div>
										<div>
											<input type="hidden" name="reserve_flag" id="reserve_flag" value="<?=$result["reserve_flag"] ?>" />
										</div>
										<div>
											<input type="hidden" name="reservation_id" id="reservation_id" value="<?=$result["reservation_id"] ?>" />
										</div>
									<div class="actions">
										<input type="submit" value="Edit" />
										<input type="reset" value="Clear" />
									</div>
								</form>
							</section>
						</div>
					</section>


	</body>
</html>
