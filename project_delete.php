<?php
//1. POSTデータ取得
require("./dbset/dbset.php");
$project_id = filter_input( INPUT_GET, "id" );

$stmt = $pdo->prepare("DELETE FROM project WHERE project_id=:project_id");
$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  header("Location: host_index.php");
  exit();
}
?>
