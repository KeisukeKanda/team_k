<?php
//1. POSTデータ取得

$user_id = $_POST["user_id"];
echo $user_id;
$title = $_POST["title"];
$category = $_POST["category"];
$country = $_POST["country"];
$project_area = $_POST["project_area"];
$experience = $_POST["experience"];
$thoughts = $_POST["thoughts"];
$tour_time = $_POST["tour_time"];
$price = $_POST["price"];

if (!empty($_FILES['project_img']['name'])) {
  $project_img = uniqid(mt_rand(), true);//ファイル名をユニーク化
  $project_img .= '.' . substr(strrchr($_FILES['project_img']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
  move_uploaded_file($_FILES['project_img']['tmp_name'], './images/' . $project_img);//imagesディレクトリにファイル保存
}

//2. DB接続します
require("db/database.php");


//３．データ登録SQL作成
$sql = "INSERT INTO project(user_id, title, category, country, project_area, experience, thoughts, tour_time, price, project_img, indate)VALUES(:user_id, :title, :category, :country, :project_area, :experience, :thoughts, :tour_time, :price, :project_img, sysdate())";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':country', $country, PDO::PARAM_STR);
$stmt->bindValue(':project_area', $project_area, PDO::PARAM_STR);
$stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
$stmt->bindValue(':thoughts', $thoughts, PDO::PARAM_STR);
$stmt->bindValue(':tour_time', $tour_time, PDO::PARAM_INT);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':project_img', $project_img, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}else{
  header("Location: project.php");//半角スペースが必須
  exit();
}
?>
