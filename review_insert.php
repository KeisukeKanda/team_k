<?php
//----------------------------------------------------
//１．入力チェック(受信確認処理追加)
//----------------------------------------------------
//内容の満足度 受信チェック:item
if(!isset($_POST["contents_review"]) || $_POST["contents_review"]==""){
  exit("ParameError!item!");
}

//ホスピタリティーの満足度 受信チェック:value
if (!isset($_POST["hospitality_review"]) || $_POST["hospitality_review"] == "") {
  exit("ParameError!value!");
}

//コミュニケーションの満足度 受信チェック:category
if (!isset($_POST["communication_review"]) || $_POST["communication_review"] == "") {
  exit("ParameError!value!");
}


//旅の長さの満足度 受信チェック:description
if (!isset($_POST["time_review"]) || $_POST["time_review"] == "") {
  exit("ParameError!description!");
}

//価格の満足度 受信チェック:description
if (!isset($_POST["price_review"]) || $_POST["price_review"] == "") {
  exit("ParameError!description!");
}

//コメント 受信チェック:description
if (!isset($_POST["comment_review"]) || $_POST["comment_review"] == "") {
  exit("ParameError!description!");
}



//----------------------------------------------------
//２. POSTデータ取得
//----------------------------------------------------
$contents_review = $_POST["contents_review"];
$hospitality_review = $_POST["hospitality_review"];
$communication = $_POST["communication_review"];
$time_review = $_POST["time_review"];
$price_review = $_POST["price_review"];
$comment_review = $_POST["comment_review"];

//----------------------------------------------------
//３. DB接続します(エラー処理追加)
//----------------------------------------------------
require("funcs.php");
require("db/database.php");

//----------------------------------------------------
//４．データ登録SQL作成
//----------------------------------------------------
$stmt = $pdo->prepare("INSERT INTO review_table(review_id, user_id, project_id, contents_review, hospitality_review, communication_review, time_review, price_review, comment_review,)
VALUES(NULL, :user_id, :project_id, :contents_review, :hospitality_review, :communication_review, :time_review, :price_review, :comment_review");
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); //数値
$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT); //数値
$stmt->bindValue(':contents_review', $contents_review, PDO::PARAM_INT); //数値
$stmt->bindValue(':hospitality_review', $hospitality_review, PDO::PARAM_INT); //数値
$stmt->bindValue(':communication_review', $communication_review, PDO::PARAM_INT); //数値
$stmt->bindValue(':time_review', $time_review, PDO::PARAM_INT); //数値
$stmt->bindValue(':price_review', $price_review, PDO::PARAM_INT); //数値
$stmt->bindValue(':comment_review', $comment_review, PDO::PARAM_STR);
$status = $stmt->execute();

//----------------------------------------------------
//５．データ登録処理後
//----------------------------------------------------
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．item.phpへリダイレクト
  header("Location: review_complete.php");
  exit;
}
