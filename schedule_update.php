<?php
//1. POSTデータ取得

$project_id = $_POST["project_id"];
$user_id = $_POST["user_id"];
$date = $_POST["date"];
$reservation_time = $_POST["reservation_time"];
$reserve_flag = $_POST["reserve_flag"];
$reservation_id = $_POST["reservation_id"];

//2. DB接続します
require("db_set/db.php");

  $sql = 'SELECT * FROM reservation WHERE reservation_id = :reservation_id LIMIT 1';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':reservation_id', (int)$_POST['reservation_id'], PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch();

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
if($status==false){
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}else{
  header("Location: schedule.php");//半角スペースが必須
  exit();
}
?>
