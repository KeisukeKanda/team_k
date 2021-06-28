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
print $result[0];}
}


//プロジェクトナンバー1のホスピタリティレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (hospitality_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
print $result[0];}
}


//プロジェクトナンバー1のコミュニケーションレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (communication_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
print $result[0];}
}


//プロジェクトナンバー1のプライスレビューの平均値を取得→表示
$stmt = $pdo->prepare("SELECT AVG (price_review) FROM review WHERE project_id=:project_id");
$stmt->bindValue(":project_id",$project_id,PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
print $result[0];}
}




?>