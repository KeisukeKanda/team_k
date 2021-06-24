<?php

session_start();

// DB接続とfancs.phpを読み込み
require("./db_set/db.php");
require("./funcs.php");

//ログインしているユーザーのIDを取得
$user_id = $_SESSION["user_id"];

// ホスト登録フォームで入力した値の受け取り
$host = $_POST["host"];

//アップデートの実行
$sql = "UPDATE users SET host=:host WHERE user_id=:user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':host', $host, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if ($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
} else {
    redirect("profile.php");
    exit();
}
