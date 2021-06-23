<?php
//1. POSTデータ取得

$project_id = $_POST["project_id"];
$user_id = $_POST["user_id"];
$date = $_POST["date"];
$reservation_time = $_POST["reservation_time"];
$reserve_flag = $_POST["reserve_flag"];

//2. DB接続します
require("db_set/db.php");



//３．データ登録SQL作成
$sql = "INSERT INTO reservation(project_id, user_id, date, reservation_time, reserve_flag, indate)VALUES(:project_id, :user_id, :date, :reservation_time, :reserve_flag, sysdate())";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':reservation_time', $reservation_time, PDO::PARAM_STR);
$stmt->bindValue(':reserve_flag', $reserve_flag, PDO::PARAM_INT);
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

