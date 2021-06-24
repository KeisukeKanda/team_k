<?php
require("db_set/db.php");
require("./funcs.php");
session_start();


$reservation_id=$_POST["reservation_id"];
$reserve_flag=$_POST["reserve_flag"];


$sql="UPDATE reserve SET reserve_flag=:reserve_flag WHERE reservation_id=:reservation_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':reserve_flag', $reserve_flag, PDO::PARAM_INT);
$stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT); 
$status = $stmt->execute();

if($status==false){
    //*** function化する！*****************
    // $error = $stmt->errorInfo();
    // exit("SQLError:".$error[2]);
    sql_error($stmt);
}else{
redirect('thx.php');
}



?>