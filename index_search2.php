<?php
session_start();
require("./db_set/db.php");
require("funcs.php");


//２．データ登録SQL作成


$search1=$_POST["search1"];
$search2=$search1;
$search3=$_POST["search3"];
$search4=$_POST["search4"];


if($search4==0){
$stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title 
AND (country LIKE :country OR project_area LIKE :project_area)
");
$stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
$stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
$stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
$status = $stmt->execute();
}

else if($search4==1){
$stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title 
AND (country LIKE :country OR project_area LIKE :project_area)
AND price<2000");
$stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
$stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
$stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
$status = $stmt->execute();
}

else if($search4==2){
$stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title 
AND (country LIKE :country OR project_area LIKE :project_area)
AND (price BETWEEN 2000 AND 5000)");
$stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
$stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
$stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
$status = $stmt->execute();
}

else if($search4==3){
$stmt = $pdo->prepare("SELECT * FROM project WHERE title LIKE :title 
AND (country LIKE :country OR project_area LIKE :project_area)
AND price>5000");
$stmt->bindValue(":country", "%".$search1."%",PDO::PARAM_STR);
$stmt->bindValue(":project_area", "%".$search2."%",PDO::PARAM_STR);
$stmt->bindValue(":title", "%".$search3."%",PDO::PARAM_STR);
$status = $stmt->execute();
}

//３．データ表示
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<img src="project_img/<?='.$result["project_img"].'?>">';
        $view .= '<p>';
        $view .= $result["title"];
        $view .= $result["experience"] . "<br>" . $result["thoughts"];
        $view .= '</p>';
    }
}
echo $view;
exit();
?>