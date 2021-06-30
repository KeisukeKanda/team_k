<?php
//1. POSTデータ取得
require("./dbset/dbset.php");
$reservation_id = filter_input( INPUT_GET, "id" );

$stmt = $pdo->prepare("DELETE FROM reservation WHERE reservation_id=:reservation_id");
$stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  header("Location: schedule.php");
  exit();
}
?>
