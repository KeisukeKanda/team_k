<?php

session_start();

require("../db/database.php");
require("../funcs.php");

    $login_id = $_POST['login-id'];
    $password = $_POST['password'];

    if (!empty($_POST['login-id'])) {
        if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
            // $sql = "SELECT * FROM users WHERE u_id=:loginId";
            // $stmt = $pdo->prepare($sql);
            // $stmt->bindValue(':loginId', $loginId);
            // $res = $stmt->execute();

            if ($res==false) {
                sql_error($stmt);
            }

            $val = $stmt->fetch();

            if (password_verify($password, $val[""]) === true) {
                if ($val[""] !="") {
                    $_SESSION["chk_ssid"] = session_id();
                    $_SESSION["u_name"] = $val[""];

                    redirect("index_login.php");
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
