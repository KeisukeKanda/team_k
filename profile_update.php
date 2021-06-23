<?php

session_start();

require("./db_set/db.php");
require("./funcs.php");

//user_idをlogin_act.phpのセッションデータから取得
$user_id = $_SESSION["user_id"];

//画像アップロード時のファイル名を作成
$image = date('YmdHis') .$_FILES['user_img']['name'];
move_uploaded_file($_FILES['user_img']['tmp_name'], './image/' . $image);

//ファイル名を代入
$user_img = './image/'.$image;

//profile.phpで送信したフォームの値を取得
$nickname = $_POST["nickname"];
$birthdate = $_POST["birthdate"];
$sex = $_POST["sex"];
$introduction = $_POST["introduction"];
$country = $_POST["country"];
$user_area = $_POST["user_area"];

//アップデートの実行
$sql = "UPDATE users SET nickname=:nickname, birthdate=:birthdate, sex=:sex, introduction=:introduction, country=:country, user_area=:user_area WHERE user_id=:user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sex', $sex, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':introduction', $introduction, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':country', $country, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_area', $user_area, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//画像が添付されなければ既存の画像を保持するように分岐処理
if (isset($_FILES["user_img"]) && $_FILES["user_img"]["error"] == UPLOAD_ERR_OK) {
    $sql = "UPDATE users SET user_img=:user_img WHERE user_id=:user_id";
    $img_update = $pdo->prepare($sql);
    $img_update->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $img_update->bindValue(':user_img', $user_img, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $img_status = $img_update->execute();
}

if ($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
} else {
    redirect("index_login.php");
    exit();
}