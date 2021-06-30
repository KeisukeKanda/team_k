<?php
//1. POSTデータ取得

$project_id = $_POST["project_id"];
$user_id = $_POST["user_id"];
$title = $_POST["title"];
$category = $_POST["category"];
$country = $_POST["country"];
$project_area = $_POST["project_area"];
$experience = $_POST["experience"];
$thoughts = $_POST["thoughts"];
$tour_time = $_POST["tour_time"];
$price = $_POST["price"];


//2. DB接続します
require("./dbset/dbset.php");

  $sql = 'SELECT * FROM project WHERE project_id = :project_id LIMIT 1';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':project_id', (int)$_POST['project_id'], PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch();

  if (empty($_FILES['project_img']['name'])) {
    $project_img = $result['project_img'];
   }
  else if (!empty($_FILES['project_img']['name'])) {
    $project_img = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $project_img .= '.' . substr(strrchr($_FILES['project_img']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
    move_uploaded_file($_FILES['project_img']['tmp_name'], './project_img/' . $project_img);//imagesディレクトリにファイル保存
  }


//３．データ登録SQL作成
$sql = "UPDATE project set user_id=:user_id, title=:title, category=:category, country=:country, project_area=:project_area, experience=:experience, thoughts=:thoughts, tour_time=:tour_time, price=:price, project_img=:project_img, indate=sysdate() WHERE project_id=:project_id";
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
$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}else{
  header("Location: host_index.php");//半角スペースが必須
  exit();
}
?>
