<?php
session_start();
require("./db_set/db.php");
require("funcs.php");



$search1=$_POST["search1"];
$search2=$search1;
$search3=$_POST["search3"];
$search5=$_POST["search5"];

//データ型変換
$date=date('Y-m-d', strtotime($search5));
//見入力の時の処理
if ($date=='1970-01-01') {
    $date='';
}

// 日付入力がされていた場合、該当するプロジェクトIDを重複なしで取得して$viewに格納
$stmt = $pdo->prepare("SELECT DISTINCT project_id FROM reservation WHERE date=:date");
$stmt->bindValue(":date", $date, PDO::PARAM_STR);
$status = $stmt->execute();
$view = '';
if ($status == false) {
    sql_error($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= $result["project_id"];
        $view .= ',';
    }
}


// (i)日付入力がされていない時
if ($date=='') {
    $view1 = rtrim($view, ",");
    $stmt2 = $pdo->prepare("SELECT*FROM project WHERE title LIKE :title 
    AND (country LIKE :country OR project_area LIKE :project_area) ");
    $stmt2->bindValue(":country", "%".$search1."%", PDO::PARAM_STR);
    $stmt2->bindValue(":project_area", "%".$search2."%", PDO::PARAM_STR);
    $stmt2->bindValue(":title", "%".$search3."%", PDO::PARAM_STR);
    $status2 = $stmt2->execute();
// (ⅱ)日付入力がされていて該当のプロジェクトが存在する場合
} elseif ($date!==''&& $view!=='') {
    $view1 = rtrim($view, ",");
    $stmt2 = $pdo->prepare("SELECT*FROM project WHERE title LIKE :title 
    AND (country LIKE :country OR project_area LIKE :project_area) AND project_id in ($view1)");
    $stmt2->bindValue(":country", "%".$search1."%", PDO::PARAM_STR);
    $stmt2->bindValue(":project_area", "%".$search2."%", PDO::PARAM_STR);
    $stmt2->bindValue(":title", "%".$search3."%", PDO::PARAM_STR);
    $status2 = $stmt2->execute();
// (ⅲ)日付入力されているが該当のプロジェクトが存在しない場合
} else {
    exit();
}

// else if($search4==1){
// $stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title
// AND (country LIKE :country OR project_area LIKE :project_area)
// AND price<2000");
// $stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
// $stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
// $stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
// $status = $stmt->execute();
// }

// else if($search4==2){
// $stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title
// AND (country LIKE :country OR project_area LIKE :project_area)
// AND (price BETWEEN 2000 AND 4999)");
// $stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
// $stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
// $stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
// $status = $stmt->execute();
// }

// else if($search4==3){
// $stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title
// AND (country LIKE :country OR project_area LIKE :project_area)
// AND price>5000");
// $stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
// $stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
// $stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
// $status = $stmt->execute();
// }

//３．データ表示
$view2 = "";
if ($status2 == false) {
    sql_error($stmt2);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $view2 .= '<div class="content">';
        $view2 .= '<div class="content-info">';
        $view2 .= '<a href="./selected_project.php?project_id='.$result2["project_id"].'">';
        $view2 .= '<div class="content-img">';
        $view2 .= '<img src="project_img/'.$result2["project_img"].'">';
        $view2 .= '</div>';
        $view2 .= '<div class="content-title">';
        $view2 .= $result2["title"];
        $view2 .= '</div>';
        $view2 .= '</a>';
        $view2 .= '</div>';
        $view2 .= '</div>';
    }
}
echo $view2;
exit();
