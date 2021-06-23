<?php

session_start();

require("../db/database.php");
require("../funcs.php");

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

//空白不可
if (!empty($_POST["name"] && $_POST["email"] && $_POST["password"]) && mb_strlen($_POST["password"]) >= 6) {
    // トークン判定
    if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
        //メアドかどうか判定
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            //u_idの重複判定
            $sql = "SELECT COUNT(*) AS cnt FROM users WHERE u_id=?";
            $stmt = $pdo->prepare($sql);
            $res = $stmt->execute(array($_POST["email"]));
            $val = $stmt->fetch();
            if ($val["cnt"] > 0) {
                echo "重複してます";
            } else {
                $sql = "INSERT INTO users(name, email, password, indate)VALUES(:name, :email, :password, sysdate())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $stmt->bindValue(':password', $hash, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $status = $stmt->execute();

                if ($status==false) {
                    $error = $stmt->errorInfo();
                    exit("SQLError:".$error[2]);
                } else {
                    $_SESSION["name"] = $u_name;
                    $_SESSION["chk_ssid"] = session_id();
                    redirect("../index_login.php");
                    exit();
                }
            }
        } else {
            echo "メアドを入れてください";
        }
    } else {
        redirect("../index.php");
    }
} else {
    redirect("signin.php");
}
