<?php
require("db/database.php");
require("./funcs.php");

session_start();
$pdo = db_conn();
     
//受け取り(GETで受けるかPOSTで受けるか未定だがとりあえず作成)
$user_id=intval($_GET["user_id"]);
$project_id=$_SESSION["project_id"];

//飛ばす
// $_SESSION["uuid"]=$uuid;
// $_SESSION["ui_f"]=$ui_f;
// $_SESSION["u_name"]=$u_name;
// $_SESSION["ifa_uuid"]=$ifa_uuid;



$sql="SELECT*FROM project WHERE project_id=:project_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue('project_id',$project_id,PDO::PARAM_INT);
$status = $stmt->execute();



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
    
<h1><?=$res["title"]?></h1>
<img src='./upload/<?=$res["project_img"];?>'>;
<p><?=$res["category"]?></p>
<p><?=$res["country"]?></p>
<p><?=$res["project_area"]?></p>
<p><?=$res["experience"]?></p>
<p><?=$res["thoughts"]?></p>
<p><?=$res["tour_time"]?></p>
<p><?=$res["price"]?></p>


<p>テスト</p>
<p>テスト</p>

</body>
</html>