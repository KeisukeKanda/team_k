<?php
session_start();
require("./db_set/db.php");
require("funcs.php");


//２．データ登録SQL作成



$search5=$_POST["search5"];
$date=date('Y-m-d' ,strtotime($search5));


$stmt = $pdo->prepare("SELECT DISTINCT project_id FROM reservation WHERE date=:date");
$stmt->bindValue(":date",$date,PDO::PARAM_STR);
$status = $stmt->execute();



$view = '';
if ($status == false) {
    sql_error($stmt);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= $result["project_id"];
        $view .= ',';
    }
}



$view1_2 = rtrim($view, ",");
// ここからループ処理テスト

$stmt2 = $pdo->prepare("SELECT*FROM project WHERE project_id in ($view1_2)");
$status2 = $stmt2->execute();


$view2 = '';
if ($status2 == false) {
    sql_error($stmt2);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $view2 .= $result2["title"];
    }
}




echo $view2;
exit();


?>


