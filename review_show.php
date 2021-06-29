<?php
session_start();
require("./db_set/db.php");
require("funcs.php");

$project_id=1;
$view='';



//プロジェクトナンバー1のコンテンツレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (contents_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
$contents_review=$result[0];}
}


//プロジェクトナンバー1のホスピタリティレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (hospitality_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
$hospitality_review=$result[0];}
}


//プロジェクトナンバー1のコミュニケーションレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (communication_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
$communication_review=$result[0];}
}


//プロジェクトナンバー1のプライスレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (price_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
$price_review=$result[0];}
}


$total_review=($price_review + $communication_review + $hospitality_review +contents_review)/4;

?>



<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sample</title>
</head>
<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="./raty-3.0.0/lib/jquery.raty.js"></script>

  <div></div>
  <script type="text/javascript">
  $('div').raty({ readOnly: true, score: <?=$total_review?> });
  </script>

</body>
</html>