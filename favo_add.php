<?php

require("./dbset/dbset.php");
require_once 'funcs.php';
session_start();
$user_id = $_SESSION["user_id"];
$name= $_SESSION["name"];

    $project_id = $_POST["project_id"];
    $status = $_POST["favo"];

    if ($status === "お気に入り登録") {
        //登録処理
        $sql = "INSERT INTO favorites(project_id, user_id, indate)VALUES(:project_id, :user_id, sysdate())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":project_id", $project_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $status = $stmt->execute();

        if ($status==false) {
            sql_error($stmt);
        } else {
            redirect("selected_project.php?user_id=".$user_id."&project_id=".$project_id);
        }
    } else {
        //削除処理
        $sql = "DELETE FROM favorites WHERE project_id=:project_id AND user_id=:user_id";
        $delete = $pdo->prepare($sql);
        $delete->bindValue(':project_id', $project_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $delete->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $status = $delete->execute();

        if ($status==false) {
            sql_error($stmt);
        } else {
            redirect("selected_project.php?user_id=".$user_id."&project_id=".$project_id);
        }
    }
