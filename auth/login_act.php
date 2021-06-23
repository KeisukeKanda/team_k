<?php

session_start();

require("../db/database.php");
require("../funcs.php");

    $email = $_POST['login_id'];
    $password = $_POST['password'];

    if (!empty($_POST['login_id'])) {
        if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $res = $stmt->execute();

            if ($res==false) {
                sql_error($stmt);
            }

            $val = $stmt->fetch();

            if (password_verify($password, $val["password"]) === true) {
                if ($val["user_id"] !="") {
                    $_SESSION["chk_ssid"] = session_id();
                    $_SESSION["name"] = $val["name"];

                    redirect("../index_login.php");
                } else {
                    redirect("login.php");
                    exit();
                }
            } else {
                redirect("login.php");
            }
        } else {
            redirect("login.php");
        }
    } else {
        echo("ログイン情報が空白です");
    }
