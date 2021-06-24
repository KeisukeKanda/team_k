<?php
require("db_set/db.php");
require("./funcs.php");
session_start();

// POSTで取ることを想定
$reservation_id=$_POST["reservation_id"];
$user_id=$_SESSION["user_id"];


// reservationテーブルから呼び出す予約日時を呼び出して表示
$sql="SELECT*FROM reservation WHERE reservation_id=:reservation_id";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(':reservation_id',$reservation_id,PDO::PARAM_INT);
$status=$stmt->execute();

//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if($status==false){
sql_error($stmt);
}else{
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>予約確認</h1>
    <p><?=$res["date"]?></p>
    <p><?=$res["reservation_time"]?>時に予約してもよろしいですか？？</p>


    <form action="reserve_com.php" method="post">
<<<<<<< HEAD
        <input type="hidden" name="reserve_flag" value="1">
        <input type="hidden" name="reservation_time" value="<?=$res["reservation_time"]?>">
        <input type="submit" value="はい">
=======
    <input type="hidden" name="reservation_id" value="<?=$res["reservation_id"]?>">
    <input type="hidden" name="user_id" value="<?=$res["user_id"]?>">
    <input type="submit" value="予約完了">
>>>>>>> 84-reserve_confirmphp
    </form>
</body>
</html>