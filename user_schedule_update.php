<?php
require("funcs.php");
require("./dbset/dbset.php");

$reserve_flag = h($_POST["reserve_flag"]);
$reservation_id = h($_POST["reservation_id"]);
$project_id = h($_POST["project_id"]);
$user_id = h($_POST["user_id"]);
$date = h($_POST["date"]);
$reservation_time = h($_POST["reservation_time"]);


//３．データ登録SQL作成
//３．データを更新
$sql = "UPDATE reservation set project_id=:project_id, user_id=:user_id, date=:date, reservation_time=:reservation_time, reserve_flag=:reserve_flag, indate=sysdate() WHERE reservation_id=:reservation_id";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':reservation_time', $reservation_time, PDO::PARAM_STR);
$stmt->bindValue(':reserve_flag', $reserve_flag, PDO::PARAM_INT);
$stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
  //*** funcsの中でfunction化したものに差し替えた！*****************
  sql_error($stmt);
} else {
  //*** funcsの中でfunction化したものに差し替えた！*****************
  redirect("user_schedule.php");
}
